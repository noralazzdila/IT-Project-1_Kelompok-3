<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tempat_pkl', function (Blueprint $table) {
            // Tambahkan kolom mahasiswa_id jika belum ada
            if (!Schema::hasColumn('tempat_pkl', 'mahasiswa_id')) {
                $table->unsignedBigInteger('mahasiswa_id')->nullable()->after('id');
            }
        });

        // Isi kolom mahasiswa_id untuk data lama berdasarkan user_id
        $tempatPklRecords = DB::table('tempat_pkl')->get();
        foreach ($tempatPklRecords as $record) {
            if ($record->user_id) {
                $mahasiswa = DB::table('mahasiswa')->where('user_id', $record->user_id)->first();
                if ($mahasiswa) {
                    DB::table('tempat_pkl')
                        ->where('id', $record->id)
                        ->update(['mahasiswa_id' => $mahasiswa->id]);
                }
            }
        }

        // Tambahkan foreign key (setelah semua data mahasiswa_id valid)
        Schema::table('tempat_pkl', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')
                  ->references('id')
                  ->on('mahasiswa')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tempat_pkl', function (Blueprint $table) {
            if (Schema::hasColumn('tempat_pkl', 'mahasiswa_id')) {
                $table->dropForeign(['mahasiswa_id']);
                $table->dropColumn('mahasiswa_id');
            }
        });
    }
};
