<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds appointment_id / hospital_id if missing (e.g. earlier migration not applied).
     */
    public function up(): void
    {
        if (Schema::hasTable('vaccination_records') && ! Schema::hasColumn('vaccination_records', 'appointment_id')) {
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->unsignedBigInteger('appointment_id')->nullable();
            });
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->foreign('appointment_id')
                    ->references('id')
                    ->on('appointments')
                    ->nullOnDelete();
            });
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->unique('appointment_id');
            });
        }

        if (Schema::hasTable('vaccines') && ! Schema::hasColumn('vaccines', 'hospital_id')) {
            Schema::table('vaccines', function (Blueprint $table) {
                $table->unsignedBigInteger('hospital_id')->nullable();
            });
            Schema::table('vaccines', function (Blueprint $table) {
                $table->foreign('hospital_id')
                    ->references('id')
                    ->on('hospitals')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vaccination_records') && Schema::hasColumn('vaccination_records', 'appointment_id')) {
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->dropForeign(['appointment_id']);
            });
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->dropColumn('appointment_id');
            });
        }

        if (Schema::hasTable('vaccines') && Schema::hasColumn('vaccines', 'hospital_id')) {
            Schema::table('vaccines', function (Blueprint $table) {
                $table->dropForeign(['hospital_id']);
            });
            Schema::table('vaccines', function (Blueprint $table) {
                $table->dropColumn('hospital_id');
            });
        }
    }
};
