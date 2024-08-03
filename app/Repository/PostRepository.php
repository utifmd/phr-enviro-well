<?php

namespace App\Repository;

use App\Mapper\IPostMapper;
use App\Models\Post;
use App\Utils\Enums\WorkOrderStatusEnum;
use App\Utils\IUtility;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostRepository implements IPostRepository
{
    private IPostMapper $mapper;
    private IUtility $utility;

    public function __construct(IPostMapper $mapper, IUtility $utility)
    {
        $this->mapper = $mapper;
        $this->utility = $utility;
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

    function pagedPosts(): LengthAwarePaginator
    {
        return Post::query()
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    public function pagedPostByUserId(string $userId): LengthAwarePaginator
    {
        $builder = Post::query()
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $builder->through(function ($post){
            $post->timeAgo = $this->utility->timeAgo($post->created_at);
            $post->woPendingReqCount = collect($post->workorders)
                ->filter(function ($wo){
                    return $wo['status'] == WorkOrderStatusEnum::STATUS_PENDING->value; })
                ->count();
            $post->desc = str_replace(';', ' ', $post->desc);
            return $post;
        });
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
