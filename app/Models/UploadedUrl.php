<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UploadedUrl
 *
 * @property $id
 * @property $url
 * @property $path
 * @property $post_id
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class UploadedUrl extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'url', 'path', 'post_id'
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(
            Post::class //, 'id', 'post_id'
        );
    }
}
