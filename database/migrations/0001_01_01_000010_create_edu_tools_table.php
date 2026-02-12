<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Katalog tools edukasi gratis
        Schema::create('edu_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // GitHub Education
            $table->string('slug')->unique();          // github-education
            $table->text('description');                // Deskripsi lengkap
            $table->text('short_description');          // Deskripsi singkat
            $table->string('icon_url')->nullable();     // URL icon/logo
            $table->string('website_url');              // URL website tool
            $table->string('claim_url')->nullable();    // URL untuk klaim benefit
            $table->enum('category', [
                'development',
                'design',
                'productivity',
                'learning',
                'cloud',
                'communication',
                'ai',
            ]);
            $table->json('benefits')->nullable();       // List benefit yang didapat
            $table->text('how_to_claim')->nullable();   // Cara klaim/aktivasi
            $table->json('requirements')->nullable();   // Syarat klaim
            $table->boolean('requires_kvt_email')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Pivot: user <-> edu_tool (tracking klaim)
        Schema::create('user_edu_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('edu_tool_id')->constrained()->onDelete('cascade');
            $table->string('kvt_email_used')->nullable();
            $table->enum('status', ['pending', 'aktif', 'expired', 'ditolak'])->default('pending');
            $table->timestamp('claimed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'edu_tool_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_edu_tools');
        Schema::dropIfExists('edu_tools');
    }
};
