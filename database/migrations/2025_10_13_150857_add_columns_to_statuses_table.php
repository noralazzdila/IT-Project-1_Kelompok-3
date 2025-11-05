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
        Schema::table('statuses', function (Blueprint $table) {
            // Tambahkan kolom-kolom yang hilang setelah kolom 'id'
            $table->string('nama_status')->after('id');
            $table->string('status')->after('nama_status');
            $table->text('keterangan')->nullable()->after('status'); // Dibuat nullable jika keterangan boleh kosong
            $table->date('tgl_update')->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('statuses', function (Blueprint $table) {
            // Ini untuk membatalkan jika terjadi kesalahan
            $table->dropColumn(['nama_status', 'status', 'keterangan', 'tgl_update']);
        });
    }
};