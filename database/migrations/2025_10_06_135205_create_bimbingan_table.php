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
    Schema::create('bimbingan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 🟢 Tambahkan baris ini
        $table->string('mahasiswa_nama');
        $table->string('nim');
        $table->string('dosen_pembimbing');
        $table->date('tanggal_bimbingan');
        $table->string('topik_bimbingan');
        $table->text('catatan')->nullable();
        $table->enum('status', ['Menunggu', 'Disetujui', 'Revisi'])->default('Menunggu');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan');
    }
};
