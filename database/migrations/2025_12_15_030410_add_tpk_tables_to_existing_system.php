<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL KRITERIA (untuk TPK)
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // C1, C2, C3, C4, C5
            $table->string('name');
            $table->enum('type', ['benefit', 'cost']);
            $table->decimal('weight', 8, 6)->default(0);
            $table->timestamps();
        });

        // 2. TABEL PERBANDINGAN AHP
        Schema::create('ahp_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_1_id')->constrained('criteria')->onDelete('cascade');
            $table->foreignId('criteria_2_id')->constrained('criteria')->onDelete('cascade');
            $table->decimal('value', 8, 4);
            $table->timestamps();
        });

        // 3. TABEL ALTERNATIVE (untuk SAW)
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('tempat_pkl_id')->constrained('tempat_pkl')->onDelete('cascade');
            $table->timestamps();
        });

        // 4. TABEL NILAI ALTERNATIVE
        Schema::create('alternative_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criteria')->onDelete('cascade');
            $table->decimal('value', 10, 4);
            $table->decimal('normalized_value', 10, 6)->nullable();
            $table->timestamps();
            
            $table->unique(['alternative_id', 'criteria_id']);
        });

        // 5. TABEL HASIL SAW
        Schema::create('saw_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->decimal('final_score', 10, 6);
            $table->integer('rank');
            $table->timestamp('calculated_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_results');
        Schema::dropIfExists('alternative_values');
        Schema::dropIfExists('alternatives');
        Schema::dropIfExists('ahp_comparisons');
        Schema::dropIfExists('criteria');
    }
};