<?php

namespace App\Mapper;

use App\Mapper\IUploadedUrlMapper;
use App\Models\UploadedUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UploadedUrlMapper implements IUploadedUrlMapper
{
    function fromBuilderOrModel(Model|Builder $model): UploadedUrl
    {
        $uploadedUrl = new UploadedUrl();
        $uploadedUrl->id = $model['id'];

        $uploadedUrl->created_at = $model['created_at'];
        $uploadedUrl->updated_at = $model['updated_at'];
        return $uploadedUrl;
    }

    function fromCollection(Collection $collection): UploadedUrl
    {
        $uploadedUrl = new UploadedUrl();
        $uploadedUrl->id = $collection->get('id');

        $uploadedUrl->created_at = $collection->get('created_at');
        $uploadedUrl->updated_at = $collection->get('updated_at');
        return $uploadedUrl;
    }
    public function toArray(UploadedUrl $uploadedUrl): array
    {
        $model = array();
        $model['id'] = $uploadedUrl->id;

        $model['url'] = $uploadedUrl->url;
        $model['path'] = $uploadedUrl->path;
        $model['post_id'] = $uploadedUrl->post_id;

        $model['created_at'] = $uploadedUrl->created_at;
        $model['updated_at'] = $uploadedUrl->updated_at;
        return $model;
    }
}
