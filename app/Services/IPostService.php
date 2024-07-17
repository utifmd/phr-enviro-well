<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Collection;

interface IPostService
{
    function addPost(array $request): ?Post;
    function getPostById(string $post_id): ?Post;
    function pagedPostBySize(int $page, int $size): Collection;
    function updatePost(string $post_id, array $request): ?Post;
    function removePost(string $post_id): bool;
}
