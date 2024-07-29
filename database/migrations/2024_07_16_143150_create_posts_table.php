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
        Schema::create('posts', function (Blueprint $table) {

            $postTypeEnums = \App\Utils\Enums\PostTypeEnum::cases();
            $allowed = collect($postTypeEnums)
                ->map(function ($mEnum){ return $mEnum->value; })
                ->toArray();

            $table->uuid('id')->primary()->unique();
            $table->enum('type', $allowed);
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
