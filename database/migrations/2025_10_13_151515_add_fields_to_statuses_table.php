<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Method 'up' akan dijalankan ketika Anda menjalankan 'php artisan migrate'
        // Kode ini akan MENGUBAH (alter) tabel 'statuses' yang sudah ada
        Schema::table('statuses', function (Blueprint $table) {
            // Menambahkan kolom-kolom baru yang dibutuhkan
            
            // Membuat kolom 'nama_status' dengan tipe data VARCHAR (string)
            // ->after('id') berarti kolom ini akan dibuat setelah kolom 'id'
            $table->string('nama_status')->after('id');

            // Membuat kolom 'status' dengan tipe data VARCHAR (string)
            $table->string('status')->after('nama_status');

            // Membuat kolom 'keterangan' dengan tipe data TEXT
            // ->nullable() berarti kolom ini boleh kosong (tidak wajib diisi)
            $table->text('keterangan')->nullable()->after('status');

            // Membuat kolom 'tgl_update' dengan tipe data DATE
            $table->date('tgl_update')->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Method 'down' akan dijalankan jika Anda melakukan rollback migrasi
        // Ini berguna untuk membatalkan perubahan yang dibuat oleh method 'up'
        Schema::table('statuses', function (Blueprint $table) {
            // Menghapus kolom-kolom yang telah ditambahkan
            $table->dropColumn(['nama_status', 'status', 'keterangan', 'tgl_update']);
        });
    }
};
