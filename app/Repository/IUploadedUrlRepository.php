<?php

namespace App\Repository;

use App\Models\UploadedUrl;
use Illuminate\Support\Collection;

interface IUploadedUrlRepository
{
    function addUploadedUrl(array $request): ?UploadedUrl;
    function updateUploadedUrl(string $uploadedUrlId, array $request): ?UploadedUrl;
    function updateUploadedUrlBy(string $postId, array $request): ?UploadedUrl;
    function getUploadedUrlById(string $post_id): Collection;
    function removeUploadedUrl(string $post_id): bool;

    /*function addUploadedUrl(array $request): ?UploadedUrl;
    function getUploadedUrlById(string $post_id): ?UploadedUrl;
    function pagedUploadedUrlBySize(int $page, int $size): Collection;
    function updateUploadedUrl(string $post_id, array $request): ?UploadedUrl;
    function removeUploadedUrl(string $post_id): bool;*/
}
