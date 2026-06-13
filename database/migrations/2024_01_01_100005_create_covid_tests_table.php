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
        if (!Schema::hasTable('covid_tests')) {
            Schema::create('covid_tests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->string('test_type')->default('PCR'); 
                $table->string('result')->default('pending');
                $table->decimal('ct_value', 5, 2)->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('tested_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('covid_tests');
    }
};
