<?php

namespace App\Repository;

use App\Mapper\IPostMapper;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::error($t->getMessage());
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
        try {
            $model = Post::query()->find($post_id);
            $model->title = $request['title'];
            $model->desc = $request['desc'];

            if(!$model->save()) return null;
            return $model
                ->get()
                ->first();

        } catch (\Throwable $t){
            Log::error($t->getMessage());
            return null;
        }
    }

    function removePost(string $post_id): bool
    {
        try {
            $model = Post::query()->find($post_id);
            return $model->delete();
        } catch (\Throwable $t) {
            Log::error($t->getMessage());
            return false;
        }
    }

    function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    function commitTransaction(): void
    {
        DB::commit();
    }

    function rollback(?int $toLevel = null): void
    {
        DB::rollBack($toLevel);
    }
}
