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
        Schema::table('pengajuan_pkl', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_pkl', 'tempat_pkl_id')) {
                $table->unsignedBigInteger('tempat_pkl_id')->nullable()->after('user_id');
                $table->foreign('tempat_pkl_id')->references('id')->on('tempat_pkl')->onDelete('set null');
            } else {
                // If exists, make it nullable
                $table->unsignedBigInteger('tempat_pkl_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pkl', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuan_pkl', 'tempat_pkl_id')) {
                $table->dropForeign(['tempat_pkl_id']);
                $table->dropColumn('tempat_pkl_id');
            }
        });
    }
};
