<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class Post
 *
 * @property $id
 * @property $type
 * @property $title
 * @property $desc
 * @property $user_id
 * @property $user
 * @property $uploadUrls
 * @property $workOrders
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Post extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        "type", "title", "desc", "user_id"
    ];
    protected static function booted(): void
    {
        self::creating(function ($table){
            $table->id = Str::uuid();
        });
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function uploadedUrls(): HasMany
    {
        return $this->hasMany(
            UploadedUrl::class //, 'id', 'work_order_id'
        );
    }
    public function workOrders(): HasMany
    {
        return $this->hasMany(
            WorkOrder::class //, 'id', 'work_order_id'
        );
    }
}
