<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use App\Service\IWellService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    private IWellService $service;

    public function booted(IWellService $service): void
    {
        $this->service = $service;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = $this->service->pagedWellPost();

        return view('livewire.post.index', compact('posts'))
            ->with('i', $this->getPage() * $posts->perPage());
    }

    public function delete(Post $post)
    {
        $post->delete();

        return $this->redirectRoute('posts.index', navigate: true);
    }
}
