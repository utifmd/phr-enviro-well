<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use App\Policies\UserPolicy;
use App\Repository\IPostRepository;
use App\Repository\IWorkOrderRepository;
use App\Utils\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Component;

class Show extends Component
{
    private IPostRepository $postRepository;
    private IWorkOrderRepository $workOrderRepository;
    public PostForm $form;
    /*#[Session]*/
    public string $currentPostId;
    public array $woIds;

    public function mount(Post $post)
    {
        $post->desc = str_replace(';', ' ', $post->desc);
        $this->form->setResponsePostModel($post);
        $this->woIds = collect($post->workorders)->map(function ($wo){ return $wo['id']; })->toArray();
        $this->currentPostId = $post->id;
    }

    public function booted(IPostRepository $postRepository, IWorkOrderRepository $workOrderRepository): void
    {
        $this->postRepository = $postRepository;
        $this->workOrderRepository = $workOrderRepository;
    }

    public function onChangeStatus(string|array $woIds, string $request)
    {
        $this->authorize(UserPolicy::IS_PHR_ROLE, $this->form->postModel);

        $request = ['status' => $request];
        $this->form->onUpdateWorkOrders(function () use ($woIds, $request){
            if (is_string($woIds))
                $this->workOrderRepository->updateWorkOrder($woIds, $request);
            if (!is_array($woIds)) return;

            foreach ($woIds as $id) {
                $this->workOrderRepository->updateWorkOrder($id, $request);
            }
        });
        return $this->redirectRoute('posts.show', ['post' => $this->currentPostId]);
    }

    public function onAllowAllRequestPressed(): void
    {
        $this->onChangeStatus(
            $this->woIds,
            WorkOrderStatusEnum::STATUS_ACCEPTED->value
        );
    }
    public function onDeniedAllRequestPressed(): void
    {
        $this->onChangeStatus(
            $this->woIds,
            WorkOrderStatusEnum::STATUS_REJECTED->value
        );
    }
    public function onDeletePressed(string $postId)
    {
        try {
            $this->form->onRemoveEvidences(function (array $paths) {
                foreach ($paths as $path) { unlink(storage_path($path)); }
            });
        } catch (\Throwable $throwable){
            Log::debug($throwable->getMessage());

        } finally {
            $this->postRepository->removePost($postId);
            $this->redirectRoute('posts.index');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.show', ['post' => $this->form->postModel]);
    }
}
