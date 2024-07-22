<?php

namespace App\Repository;

use App\Mapper\IPostMapper;
use App\Models\Post;
use Illuminate\Support\Collection;

class PostRepository implements IPostRepository
{
    private IPostMapper $mapper;

    public function __construct(IPostMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    function addPost(array $request): ?Post
    {
        $createdPost = Post::query()->create($request);
        $post = $this->mapper->fromBuilderOrModel($createdPost);

        if (is_null($post->id)) return null;
        return $post;
    }

    function getPostById(string $post_id): ?Post
    {
        try {
            $post = Post::query()->find($post_id)->get();
        } catch (\Throwable $t) {
            return null;
        }
        return $post->first();
    }

    function pagedPostBySize(int $page, int $size): Collection
    {
        return collect();
    }

    function updatePost(string $post_id, array $request): ?Post
    {
        $model = Post::query()->find($post_id);
        $model->title = $request['title'];
        $model->desc = $request['desc'];

        if(!$model->save()) return null;
        return $model
            ->get()
            ->first();
    }

    function removePost(string $post_id): bool
    {
        $model = Post::query()->find($post_id);
        return $model->delete();
    }
}
