<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->uuid('school_id')->nullable();
            $table->string('action'); // create, update, delete, login, logout, etc.
            $table->string('model_type')->nullable();
            $table->string('model_id')->nullable();
            $table->text('description')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->index(['user_id', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
