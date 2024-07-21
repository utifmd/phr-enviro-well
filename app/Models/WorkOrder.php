<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class WorkOrder
 *
 * @property $id
 * @property $shift
 * @property $well_number
 * @property $wbs_number
 * @property $is_rig
 * @property $status
 * @property $post_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkOrder extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'shift', 'well_number', 'wbs_number', 'is_rig', 'status', 'post_id',
    ];
    protected static function booted(): void
    {
        self::creating(function ($table) {
            $table->id = Str::uuid();
        });
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(
            Post::class //, 'id', 'post_id'
        );
    }
}