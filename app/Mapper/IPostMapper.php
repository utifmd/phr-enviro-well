<?php

namespace App\Mapper;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IPostMapper
{
    function fromAndRawArray(array $post): Post;
    function fromCollection(Collection $post): Post;
    function fromBuilderOrModel(Builder|Model $model): Post;
}
