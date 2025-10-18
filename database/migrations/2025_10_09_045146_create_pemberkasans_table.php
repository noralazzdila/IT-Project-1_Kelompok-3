<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemberkasans', function (Blueprint $table) {
            $table->id();

            // KOREKSI DILAKUKAN DI SINI:
            // Mengubah 'mahasiswas' menjadi 'mahasiswa'
            $table->foreignId('mahasiswa_id')
                  ->constrained('mahasiswa') // <--- DIKOREKSI menjadi nama tabel yang benar
                  ->onDelete('cascade');     
                  
            $table->unique('mahasiswa_id');
            
            $table->string('form_bimbingan_path')->nullable();
            $table->string('sertifikat_path')->nullable();
            $table->string('laporan_final_path')->nullable();
            
            $table->boolean('is_lengkap')->default(false);
            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberkasans');
    }
};