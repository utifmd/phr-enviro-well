<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public PostForm $form;

    public function mount(Post $post)
    {
        $post->desc = str_replace(';', ' ', $post->desc);
        $this->form->setResponsePostModel($post);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.show', ['post' => $this->form->postModel]);
    }
}
