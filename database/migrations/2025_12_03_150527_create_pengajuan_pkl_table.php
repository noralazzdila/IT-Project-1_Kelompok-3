<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel pengajuan_pkl jika belum ada
        if (!Schema::hasTable('pengajuan_pkl')) {
            Schema::create('pengajuan_pkl', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('pdf_path')->nullable();
                $table->enum('status', ['uploaded', 'diproses', 'diterima', 'ditolak'])->default('uploaded');

                // Data tempat PKL (tahap 2)
                $table->string('nama_perusahaan')->nullable();
                $table->string('bidang')->nullable();
                $table->text('alamat')->nullable();
                $table->string('nama_pic')->nullable();
                $table->string('telepon_pic')->nullable();

                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pkl');
    }
};
