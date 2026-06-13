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
        if (!Schema::hasTable('vaccination_records')) {
            Schema::create('vaccination_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('vaccine_id')->constrained()->cascadeOnDelete();
                $table->integer('dose_number')->default(1);
                $table->string('status')->default('scheduled');
                $table->timestamp('vaccinated_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_records');
    }
};
