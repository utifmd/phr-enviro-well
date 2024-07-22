<?php

namespace App\Repository;

use App\Models\UploadedUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UploadedUrlRepository implements IUploadedUrlRepository
{
    function addUploadedUrl(array $request): ?UploadedUrl
    {
        $model = UploadedUrl::query()->create($request);
        $uploadedUrl = $this->fromBuilderOrModel($model);

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

    private function fromBuilderOrModel(Model|Builder $model): UploadedUrl
    {
        $uploadedUrl = new UploadedUrl();
        $uploadedUrl->id = $model['id'];

        $uploadedUrl->created_at = $model['created_at'];
        $uploadedUrl->updated_at = $model['updated_at'];
        return $uploadedUrl;
    }
}
