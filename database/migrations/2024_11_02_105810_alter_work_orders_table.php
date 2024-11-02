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
        Schema::table('work_orders', function (Blueprint $table): void {
            $table->foreignId('operator_id')->nullable()
                ->constrained('operators');

            $table->foreignId('vehicle_id')->nullable()
                ->constrained('vehicles');

            $table->foreignId('crew_id')->nullable()
                ->constrained('crews');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table): void {
            $table->removeColumn('operator_id');
            $table->removeColumn('vehicle_id');
            $table->removeColumn('crew_id');
        });
    }
};
