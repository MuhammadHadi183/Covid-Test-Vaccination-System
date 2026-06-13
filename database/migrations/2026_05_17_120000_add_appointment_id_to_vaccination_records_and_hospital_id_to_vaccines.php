<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('vaccines') && ! Schema::hasColumn('vaccines', 'hospital_id')) {
            Schema::table('vaccines', function (Blueprint $table) {
                $table->foreignId('hospital_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }

        if (Schema::hasTable('vaccination_records') && ! Schema::hasColumn('vaccination_records', 'appointment_id')) {
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->foreignId('appointment_id')->nullable()->after('hospital_id')->constrained()->nullOnDelete();
                $table->unique('appointment_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vaccination_records') && Schema::hasColumn('vaccination_records', 'appointment_id')) {
            Schema::table('vaccination_records', function (Blueprint $table) {
                $table->dropConstrainedForeignId('appointment_id');
            });
        }

        if (Schema::hasTable('vaccines') && Schema::hasColumn('vaccines', 'hospital_id')) {
            Schema::table('vaccines', function (Blueprint $table) {
                $table->dropConstrainedForeignId('hospital_id');
            });
        }
    }
};
