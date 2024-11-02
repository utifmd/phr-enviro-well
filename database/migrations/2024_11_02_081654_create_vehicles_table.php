<?php

use App\Utils\Enums\VehicleTypeEnum;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $allowedType = collect(VehicleTypeEnum::cases())
                ->map(function ($case) {return $case->value;})
                ->toArray();

            $table->string('plat')->nullable(false)->unique();
            $table->enum('type', $allowedType);
            $table->string('vendor');

            $table->foreignId('operator_id')
                ->constrained('operators')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
