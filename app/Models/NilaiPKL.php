<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_pkl', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel tempat_pkl
            $table->foreignId('tempatpkl_id')
                  ->constrained('tempat_pkl')
                  ->onDelete('cascade');

            $table->integer('nilai')->nullable();  // Nilai dari koor PKL
            $table->text('catatan')->nullable();   // Catatan atau komentar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_pkl');
    }
};
