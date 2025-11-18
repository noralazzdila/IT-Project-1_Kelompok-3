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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('prodi')->nullable();
            $table->string('kelas')->nullable();
            $table->string('tahun_angkatan')->nullable();
            $table->string('dosen_pembimbing')->nullable();
            $table->string('tempat_pkl')->nullable();
            $table->string('status_pkl')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->dropColumn(['jurusan', 'angkatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'tanggal_lahir', 'prodi', 'kelas', 'tahun_angkatan', 'dosen_pembimbing', 'tempat_pkl', 'status_pkl', 'no_hp', 'email']);
            $table->string('jurusan')->nullable();
            $table->string('angkatan')->nullable();
        });
    }
};
