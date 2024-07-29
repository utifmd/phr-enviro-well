<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public PostForm $form;

    public function mount(Post $post)
    {
        $this->form->setRequestPostModel($post);
    }

    public function onAddLoadTimePressed(): void
    {
        $this->form->pushLoadedDatetime();
    }

    public function save(): void
    {
        Log::debug('save: '. json_encode($this->form->loaded_datetime));
        /*$this->form->store();
        return $this->redirectRoute('posts.index', navigate: true);*/
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.create');
    }
}
