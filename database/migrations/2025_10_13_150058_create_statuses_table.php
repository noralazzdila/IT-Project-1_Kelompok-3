<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('statuses', function (Blueprint $table) {
        $table->date('tgl_update')->nullable()->after('nama_status');
    });
}

public function down(): void
{
    Schema::table('statuses', function (Blueprint $table) {
        $table->dropColumn('tgl_update');
    });
}

};


