<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            // Tambahkan kolom sheet_name hanya jika belum ada
            if (!Schema::hasColumn('nilai', 'sheet_name')) {
                $table->string('sheet_name')->nullable()->after('total_sks');
            }
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            if (Schema::hasColumn('nilai', 'sheet_name')) {
                $table->dropColumn('sheet_name');
            }
        });
    }
};
