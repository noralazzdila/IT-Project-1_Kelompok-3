<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tempat_pkl', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['mahasiswa_id']); 

            // Baru hapus kolom
            $table->dropColumn('mahasiswa_id');
        });
    }

    public function down(): void
    {
        Schema::table('tempat_pkl', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id')->after('id');

            // Tambahkan foreign key kembali
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
