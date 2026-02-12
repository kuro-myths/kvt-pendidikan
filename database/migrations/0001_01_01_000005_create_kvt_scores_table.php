<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kvt_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->uuid('school_id');
            $table->string('kompetensi');
            $table->string('sub_kompetensi')->nullable();
            $table->decimal('nilai', 5, 2)->default(0);
            $table->string('predikat')->nullable(); // A, B, C, D, E
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('tahun_ajaran');
            $table->text('catatan')->nullable();
            $table->foreignId('dinilai_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->index(['student_id', 'semester', 'tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kvt_scores');
    }
};
