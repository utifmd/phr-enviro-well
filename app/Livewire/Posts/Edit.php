<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Mapper\IUploadedUrlMapper;
use App\Models\Post;
use App\Models\WellMaster;
use App\Policies\PostPolicy;
use App\Repository\IPostRepository;
use App\Repository\IWorkOrderRepository;
use App\Service\IWellService;
use App\Utils\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    private ?IWellService $service;
    private IWorkOrderRepository $workOrderRepository;
    private IUploadedUrlMapper $uploadedUrlMapper;

    public PostForm $form;
    public array $woIds;
    public string $currentPostId;

    // #[Validate('required|image|max:2048')]
    public $imageFile;

    public function mount(Post $post)
    {
        $this->form->setRequestUpdatePostModel($post);
        $this->currentPostId = $post->id;
        $this->woIds = collect($post->workorders)
            ->map(function ($wo){ return $wo['id']; })
            ->toArray();
    }

    public function booted(
        IWellService $service, IWorkOrderRepository $workOrderRepository, IUploadedUrlMapper $uploadedUrlMapper): void
    {
        $this->service = $service;
        $this->workOrderRepository = $workOrderRepository;
        $this->uploadedUrlMapper = $uploadedUrlMapper;
    }

    public function onAddLoadTimePressed(): void
    {
        $this->form->pushLoadedDatetime();
    }

    public function onRemoveLoadTimePressed(int $i): void
    {
        $this->form->filteredLoadedDatetimeAt($i);
    }

    public function onEditSubmit()
    {
        $this->authorize(PostPolicy::IS_USER_OWNED, $this->form->postModel);
        $this->form->edit(function (
            $post, $uploadedUrl, $workOrders) {
            $post['id'] = $this->currentPostId;
            if ($this->imageFile) {
                try {
                    $path = "images/" . $this->form->user_id . "/";
                    $fileName = $path . date('YmdHis') . "." . $this->imageFile->getClientOriginalExtension();

                    $this->imageFile->storeAs('public', $fileName);
                    $uploadedUrl['path'] = 'app/public/'.$fileName;
                    $uploadedUrl['url'] = URL::asset("storage/" . $fileName);

                    $this->form->onRemoveEvidences(function (array $paths) {
                        foreach ($paths as $path) { unlink(storage_path($path)); }
                    });
                } catch (\Throwable $throwable) {
                    Log::debug('Edit>store>upload/delete: '.$throwable->getMessage());
                }
            }
            $this->service->updateWell(
                $post, $uploadedUrl, $workOrders
            );
            Session::remove(WellMaster::WELL_MASTER_NAME);
        });
        return $this->redirectRoute('posts.index', navigate: true);
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.edit');
    }
}
