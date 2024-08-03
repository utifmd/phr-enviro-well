<?php

namespace App\Livewire\Posts;

use App\Repository\IPostRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LoadRequest extends Component
{
    use WithPagination;
    private IPostRepository $postRepository;

    public function booted(IPostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = $this->postRepository->pagedPosts();
        return view('livewire.post.index', compact('posts'))
            ->with('i', $posts->perPage() * $this->getPage());
    }
}
