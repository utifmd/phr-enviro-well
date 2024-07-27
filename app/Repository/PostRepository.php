<?php

namespace App\Repository;

use App\Mapper\IPostMapper;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    function getPostById(string $postId): ?Post
    {
        try {
            $post = Post::query()->find($postId)->get();
        } catch (Throwable $t) {
            Log::error($t->getMessage());
            return null;
        }
        return $post->first();
    }

    function pagedPostBySize(?int $page = null, ?int $size = null): LengthAwarePaginator
    {
        return Post::query()->paginate(
            perPage: $size, page: $page
        );
    }

    public function pagedPostByUserId(string $userId, ?int $page = null): LengthAwarePaginator
    {
        return Post::query()->where('user_id', '=', $userId)->paginate();
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

        } catch (Throwable $t){
            Log::error($t->getMessage());
            return null;
        }
    }

    function removePost(string $post_id): bool
    {
        try {
            $model = Post::query()->find($post_id);
            return $model->delete();
        } catch (Throwable $t) {
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
