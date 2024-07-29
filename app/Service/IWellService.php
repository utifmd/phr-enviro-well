<?php

namespace App\Service;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IWellService
{
    function addNewWell(
        array $postRequest, array $uploadedUrlRequest, array $workOrdersRequest): ?Post;

    function getWellPostById(string $postId): ?Post;
    function getCountOfLoadPerMonth(int $month): ?array;

    function pagedWellPost(?int $page): LengthAwarePaginator;

    /*function searchWellPostByName(string $wellName): ?Post;
    function removeWellPost(string $wellId): bool;*/

    function pagedWellMaster(?string $query, ?int $page): LengthAwarePaginator;
}
