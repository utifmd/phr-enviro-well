<?php

namespace App\Service;

use App\Models\Post;

interface IPostService
{
    function addNewWell(
        array $postRequest, array $workOrderRequest, array $uploadedUrlRequest): ?Post;

    function getWellPostById(string $postId): ?Post;

    /*function pagedWellPost(int $page): ?Post;
    function searchWellPostByName(string $wellName): ?Post;
    function removeWellPost(string $wellId): bool;*/
}
