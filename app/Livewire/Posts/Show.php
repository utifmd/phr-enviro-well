<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use App\Repository\IWorkOrderRepository;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Component;

class Show extends Component
{
    private IWorkOrderRepository $workOrderRepository;
    public PostForm $form;

    #[Session]
    public $currentPostId;

    public function mount(Post $post)
    {
        $post->desc = str_replace(';', ' ', $post->desc);
        $post->woIds = collect($post->workorders)->map(function ($wo){ return $wo['id']; });
        $this->form->setResponsePostModel($post);
        $this->currentPostId = $post->id;
    }

    public function booted(IWorkOrderRepository $workOrderRepository): void
    {
        $this->workOrderRepository = $workOrderRepository;
    }

    public function onChangeStatus(string|array $woIds, string $request)
    {
        $request = ['status' => $request];
        $this->form->onUpdateWorkOrder(function () use ($woIds, $request){
            if (is_string($woIds))
                $this->workOrderRepository->updateWorkOrder($woIds, $request);
            if (!is_array($woIds)) return;

            foreach ($woIds as $id) {
                $this->workOrderRepository->updateWorkOrder($id, $request);
            }
        });
        return $this->redirect('/posts/show/'.$this->currentPostId, navigate: true);
    }

    public function delete($id = null)
    {
        Log::debug("delete triggered $id");
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.show', ['post' => $this->form->postModel]);
    }
}
