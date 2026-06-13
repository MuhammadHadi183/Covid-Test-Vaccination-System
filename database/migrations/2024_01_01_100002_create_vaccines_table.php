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
        if (!Schema::hasTable('vaccines')) {
            Schema::create('vaccines', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('manufacturer');
                $table->integer('doses_required')->default(2);
                $table->text('description')->nullable();
                $table->string('status')->default('available');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
