<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use App\Models\WellMaster;
use App\Repository\IPostRepository;
use App\Repository\IWorkOrderRepository;
use App\Utils\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    private IWorkOrderRepository $workOrderRepository;
    public PostForm $form;
    public array $woIds;
    public string $currentPostId;

    public function mount(Post $post)
    {
        $this->form->setResponsePostModel($post);
        $this->currentPostId = $post->id;
        $this->woIds = collect($post->workorders)
            ->map(function ($wo){ return $wo['id']; })
            ->toArray();
    }

    public function booted(IWorkOrderRepository $workOrderRepository): void
    {
        $this->workOrderRepository = $workOrderRepository;
    }

    public function onAddLoadTimePressed(): void
    {
        $this->form->pushLoadedDatetime();
    }

    public function onRemoveLoadTimePressed(int $i): void
    {
        $this->form->filteredLoadedDatetimeAt($i);
    }

    public function onChangeRequest()
    {
        $this->authorize('update-post', $this->form->postModel);

        $currentWoIds = $this->woIds;
        $request = [
            'status' => WorkOrderStatusEnum::STATUS_PENDING->value,
            'shift' => $this->form->shift,
            'is_rig' => $this->form->is_rig,
            'ids_wellname' => $this->form->title,
            'post_id' => $this->currentPostId,
        ];
        $this->form->onUpdateWorkOrders(function () use ($currentWoIds, $request){
            foreach ($currentWoIds as $id){
                $this->workOrderRepository->removeWorkOrder($id);
            }
            foreach ($this->form->loaded_datetime as $time) {
                $request['created_at'] = $time;
                $this->workOrderRepository->addWorkOrder($request);
            }
        });
        return $this->redirectRoute('posts.show', ['post' => $this->currentPostId]);
    }

    public function save()
    {
        $this->form->store(function (
            $post, $uploadedUrl, $workOrders){
            $this->service->addNewWell($post, $uploadedUrl, $workOrders);

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
