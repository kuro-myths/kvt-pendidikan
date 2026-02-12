<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kvt_licenses', function (Blueprint $table) {
            $table->id();
            $table->uuid('school_id');
            $table->enum('tipe_lisensi', ['basic', 'pro', 'premium'])->default('basic');
            $table->date('berlaku_mulai');
            $table->date('berlaku_sampai');
            $table->enum('status', ['aktif', 'nonaktif', 'kadaluarsa'])->default('aktif');
            $table->integer('max_guru')->default(10);
            $table->integer('max_siswa')->default(100);
            $table->integer('max_kelas')->default(5);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kvt_licenses');
    }
};
