<?php

namespace App\Mapper;

use App\Models\UploadedUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IUploadedUrlMapper
{
    function fromBuilderOrModel(Model|Builder $model): UploadedUrl;
    function fromCollection(Collection $collection): UploadedUrl;
    function toArray(UploadedUrl $uploadedUrl): array;
}
