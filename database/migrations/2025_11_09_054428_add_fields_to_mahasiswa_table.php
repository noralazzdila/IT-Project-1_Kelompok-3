<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
    if (!Schema::hasColumn('mahasiswa', 'jenis_kelamin')) {
        $table->string('jenis_kelamin')->nullable()->after('nama');
    }
    if (!Schema::hasColumn('mahasiswa', 'tanggal_lahir')) {
        $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
    }
    if (!Schema::hasColumn('mahasiswa', 'email')) {
        $table->string('email')->nullable()->after('tanggal_lahir');
    }
    if (!Schema::hasColumn('mahasiswa', 'prodi')) {
        $table->string('prodi')->nullable()->after('email');
    }
    if (!Schema::hasColumn('mahasiswa', 'kelas')) {
        $table->string('kelas')->nullable()->after('prodi');
    }
    if (!Schema::hasColumn('mahasiswa', 'tahun_angkatan')) {
        $table->string('tahun_angkatan')->nullable()->after('kelas');
    }
    if (!Schema::hasColumn('mahasiswa', 'dosen_pembimbing')) {
        $table->unsignedBigInteger('dosen_pembimbing')->nullable()->after('tahun_angkatan');
    }
    if (!Schema::hasColumn('mahasiswa', 'tempat_pkl')) {
        $table->string('tempat_pkl')->nullable()->after('dosen_pembimbing');
    }
    if (!Schema::hasColumn('mahasiswa', 'status_pkl')) {
        $table->string('status_pkl')->nullable()->after('tempat_pkl');
    }
    if (!Schema::hasColumn('mahasiswa', 'no_hp')) {
        $table->string('no_hp')->nullable()->after('status_pkl');
    }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'tanggal_lahir',
                'email',
                'prodi',
                'kelas',
                'tahun_angkatan',
                'dosen_pembimbing',
                'tempat_pkl',
                'status_pkl',
                'no_hp',
            ]);
        });
    }
};
