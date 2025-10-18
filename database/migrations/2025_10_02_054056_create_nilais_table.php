<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel mahasiswa
            $table->foreignId('mahasiswa_id')
                  ->constrained('mahasiswa')
                  ->onDelete('cascade');

            $table->decimal('ipk', 3, 2)->nullable();
            $table->integer('count_a')->default(0);
            $table->integer('count_b_plus')->default(0);
            $table->integer('count_b')->default(0);
            $table->integer('count_c_plus')->default(0);
            $table->integer('count_c')->default(0);
            $table->integer('count_d')->default(0);
            $table->integer('count_e')->default(0);
            $table->integer('total_sks')->default(0);

            $table->timestamps();

            $table->string('sheet_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }

};
