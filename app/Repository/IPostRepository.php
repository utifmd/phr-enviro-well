<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface IPostRepository
{
    function addPost(array $request): ?Post;
    function getPostById(string $postId): ?Post;
    function pagedPosts(?string $idsWellName): LengthAwarePaginator;
    function pagedPostByUserId(string $userId): LengthAwarePaginator;
    function updatePost(string $post_id, array $request): ?Post;
    function removePost(string $post_id): bool;

    function beginTransaction(): void;
    function commitTransaction(): void;
    function rollback(?int $toLevel): void;
}
