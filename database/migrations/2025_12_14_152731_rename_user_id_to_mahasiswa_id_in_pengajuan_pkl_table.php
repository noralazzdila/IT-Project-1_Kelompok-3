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
            if (Schema::hasColumn('pengajuan_pkl', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->renameColumn('user_id', 'mahasiswa_id');
                $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pkl', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuan_pkl', 'mahasiswa_id')) {
                $table->dropForeign(['mahasiswa_id']);
                $table->renameColumn('mahasiswa_id', 'user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }
};
