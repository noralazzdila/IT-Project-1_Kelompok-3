<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya buat jika tabel belum ada
        if (!Schema::hasTable('tempat_pkl')) {
            Schema::create('tempat_pkl', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('mahasiswa_id');
                $table->string('nama_perusahaan');
                $table->string('bidang');
                $table->text('alamat');
                $table->string('nama_pic')->nullable();
                $table->string('telepon_pic')->nullable();
                $table->string('pdf_transkrip');
                $table->string('status')->default('Menunggu Persetujuan');
                $table->timestamps();

                $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tempat_pkl');
    }
};
