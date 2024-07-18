<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public PostForm $form;

    public function mount(Post $post)
    {
        $this->form->setPostModel($post);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('posts.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.edit');
    }
}
