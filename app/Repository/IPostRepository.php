<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Support\Collection;

interface IPostRepository
{
    function addPost(array $request): ?Post;
    function getPostById(string $post_id): ?Post;
    function pagedPostBySize(int $page, int $size): Collection;
    function updatePost(string $post_id, array $request): ?Post;
    function removePost(string $post_id): bool;

    function beginTransaction(): void;
    function commitTransaction(): void;

    function rollback(?int $toLevel): void;
}
