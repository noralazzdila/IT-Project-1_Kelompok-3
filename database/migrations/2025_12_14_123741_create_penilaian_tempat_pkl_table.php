<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_tempat_pkl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('tempat_pkl_id');
            
            $table->string('nama_tempat');
            $table->text('alamat');
            $table->decimal('jarak', 8, 2); // dalam KM
            
            // Rating 1-5
            $table->tinyInteger('fasilitas'); // 1-5
            $table->tinyInteger('program_magang'); // 1-5
            $table->tinyInteger('reputasi'); // 1-5
            $table->tinyInteger('kondisi_lingkungan'); // 1-5
            
            $table->text('komentar')->nullable(); // Optional feedback
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tempat_pkl_id')->references('id')->on('tempat_pkl')->onDelete('cascade');
            
            // Satu mahasiswa hanya bisa menilai satu tempat PKL sekali
            $table->unique(['mahasiswa_id', 'tempat_pkl_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_tempat_pkl');
    }
};