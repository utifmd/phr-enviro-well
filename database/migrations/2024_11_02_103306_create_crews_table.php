<?php

use App\Utils\Enums\CrewRoleEnum;
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
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->integer('role')
                ->default(CrewRoleEnum::OPERATOR_ROLE->value)
                ->nullable(false);

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
        Schema::dropIfExists('crews');
    }
};
