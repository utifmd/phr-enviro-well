<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('well_masters', function (Blueprint $table) {
            $statusAllowed = collect(\App\Utils\WellMasterStatusEnum::cases())
                ->map(function ($case) { return $case->value; })
                ->toArray();

            $table->uuid('id')->primary()->unique();
            $table->string('field_name');
            $table->string('ids_wellname')->nullable();
            $table->string('well_number');
            $table->string('legal_well');
            $table->string('job_type')->nullable();
            $table->string('job_sub_type')->nullable();
            $table->string('rig_type')->nullable();
            $table->string('rig_no');
            $table->string('wbs_number');
            $table->string('actual_drmi')->nullable();
            $table->string('actual_spud')->nullable();
            $table->string('actual_drmo')->nullable();
            $table->enum('status', $statusAllowed);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('well_masters');
    }
};
