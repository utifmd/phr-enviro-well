<?php

namespace App\Services;

use App\Models\UploadedUrl;
use Illuminate\Support\Collection;

interface IUploadedUrlService
{
    function addUploadedUrl(array $request): ?UploadedUrl;
    function getUploadedUrlById(string $post_id): Collection;
    function removeUploadedUrl(string $post_id): bool;

    /*function addUploadedUrl(array $request): ?UploadedUrl;
    function getUploadedUrlById(string $post_id): ?UploadedUrl;
    function pagedUploadedUrlBySize(int $page, int $size): Collection;
    function updateUploadedUrl(string $post_id, array $request): ?UploadedUrl;
    function removeUploadedUrl(string $post_id): bool;*/
}
