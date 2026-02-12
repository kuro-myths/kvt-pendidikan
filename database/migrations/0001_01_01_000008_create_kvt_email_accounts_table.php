<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kvt_email_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->uuid('school_id')->nullable();
            $table->string('kvt_email')->unique(); // e.g. rizki@kvt.1, budi@kvt.2
            $table->string('display_name');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->json('email_data')->nullable(); // Store additional email account data
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kvt_email_accounts');
    }
};
