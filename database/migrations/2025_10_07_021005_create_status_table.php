<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status', 100);
            $table->string('status', 50)->nullable();
            $table->text('keterangan')->nullable();
            $table->dateTime('tgl_update')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status');
    }
};

