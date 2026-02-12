<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->uuid('school_id');
            $table->string('nama_kelas');
            $table->string('jurusan')->nullable();
            $table->string('tingkat')->nullable(); // X, XI, XII
            $table->string('tahun_ajaran');
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });

        Schema::create('class_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['class_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_student');
        Schema::dropIfExists('classes');
    }
};
