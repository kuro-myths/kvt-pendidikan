<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('school_code')->unique(); // e.g. kvt.1, kvt.2, kvt.3
            $table->string('npsn')->unique();
            $table->string('nama_sekolah');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email_kontak')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->enum('jenjang', ['SD', 'SMP', 'SMA', 'SMK', 'MA', 'Lainnya'])->default('SMA');
            $table->enum('status', ['pending', 'aktif', 'nonaktif', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Add foreign key to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
        Schema::dropIfExists('schools');
    }
};
