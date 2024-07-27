<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WellMaster extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    // protected $perPage = 10;

    protected $fillable = [
        'field_name', 'ids_wellname', 'well_number', 'legal_well', 'job_type', 'job_sub_type', 'rig_type', 'rig_no', 'wbs_number', 'actual_drmi', 'actual_spud', 'actual_drmo', 'status'
    ];

    protected static function booted(): void
    {
        self::creating(function ($table) {
            $table->id = Str::uuid();
        });
    }
}
