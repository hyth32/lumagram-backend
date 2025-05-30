<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('follower_id')->constrained('users')->cascadeOnDelete();
            $table->smallInteger('status');

            $table->unique(['user_id', 'follower_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
