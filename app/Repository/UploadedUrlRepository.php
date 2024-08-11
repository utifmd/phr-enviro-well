<?php

namespace App\Repository;

use App\Mapper\IUploadedUrlMapper;
use App\Models\UploadedUrl;
use Illuminate\Database\Eloquent\Collection;

class UploadedUrlRepository implements IUploadedUrlRepository
{
    private IUploadedUrlMapper $mapper;

    public function __construct(IUploadedUrlMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    function addUploadedUrl(array $request): ?UploadedUrl
    {
        $model = UploadedUrl::query()->create($request);
        $uploadedUrl = $this->mapper->fromBuilderOrModel($model);

        if (is_null($uploadedUrl->id)) return null;
        return $uploadedUrl;
    }

    function getUploadedUrlById(string $post_id): Collection
    {
        $builder = UploadedUrl::query()->where(
            'post_id', '=', $post_id
        );
        return $builder->get();
    }

    function removeUploadedUrl(string $post_id): bool
    {
        $builder = UploadedUrl::query()->where(
            'post_id', '=', $post_id
        );
        return $builder->delete();
    }

    public function updateUploadedUrl(
        string $uploadedUrlId, array $request): ?UploadedUrl
    {
        $model = UploadedUrl::query()->find($uploadedUrlId);
        $model->url = $request['url'];
        $model->path = $request['path'];
        $model->post_id = $request['post_id'];

        if(!$model->save()) return null;
        return $model
            ->get()
            ->first();
    }

    function updateUploadedUrlBy(
        string $postId, array $request): ?UploadedUrl
    {
        $builder = UploadedUrl::query()
            ->where('post_id', '=', $postId);

        $updatedCount = $builder
            ->update($request);

        $current = $updatedCount < 1 ? $builder->get() : null;
        if ($current == null) return null;

        return $this->mapper->fromCollection($current);
    }
}
