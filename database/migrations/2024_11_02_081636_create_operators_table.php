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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->nullable();
            $table->string('postfix')->nullable();
            $table->string('name')->nullable(false);
            $table->string('short_name')->nullable(false)->unique(true);

            $table->foreignId('department_id')->nullable()
                ->constrained('departments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
