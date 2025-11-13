<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan tabelnya ada dulu
        if (Schema::hasTable('status')) {
            Schema::table('status', function (Blueprint $table) {
                if (!Schema::hasColumn('status', 'nama_status')) {
                    $table->string('nama_status')->after('id');
                }
                if (!Schema::hasColumn('status', 'status')) {
                    $table->string('status')->after('nama_status');
                }
                if (!Schema::hasColumn('status', 'keterangan')) {
                    $table->text('keterangan')->nullable()->after('status');
                }
                if (!Schema::hasColumn('status', 'tgl_update')) {
                    $table->date('tgl_update')->after('keterangan');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('status')) {
            Schema::table('status', function (Blueprint $table) {
                if (Schema::hasColumn('status', 'nama_status')) {
                    $table->dropColumn('nama_status');
                }
                if (Schema::hasColumn('status', 'status')) {
                    $table->dropColumn('status');
                }
                if (Schema::hasColumn('status', 'keterangan')) {
                    $table->dropColumn('keterangan');
                }
                if (Schema::hasColumn('status', 'tgl_update')) {
                    $table->dropColumn('tgl_update');
                }
            });
        }
    }
};
