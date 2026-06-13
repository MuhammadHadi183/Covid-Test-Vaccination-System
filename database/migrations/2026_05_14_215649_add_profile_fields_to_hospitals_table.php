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
        Schema::table('hospitals', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('description');
            $table->string('email')->nullable()->after('logo');
            $table->string('website')->nullable()->after('email');
            $table->integer('established_year')->nullable()->after('website');
            $table->string('operating_hours')->nullable()->after('established_year');
            $table->integer('total_rooms')->default(0)->after('operating_hours');
            $table->integer('total_beds')->default(0)->after('total_rooms');
            $table->integer('icu_beds')->default(0)->after('total_beds');
            $table->boolean('emergency_available')->default(false)->after('icu_beds');
            $table->boolean('ambulance_available')->default(false)->after('emergency_available');
            $table->text('doctors_list')->nullable()->after('ambulance_available');
            $table->text('special_doctors')->nullable()->after('doctors_list');
            $table->text('specialties')->nullable()->after('special_doctors');
            $table->text('facilities')->nullable()->after('specialties');
            $table->decimal('rating', 2, 1)->default(0)->after('facilities');
            $table->integer('total_reviews')->default(0)->after('rating');
            $table->text('reviews')->nullable()->after('total_reviews');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn([
                'logo', 'email', 'website', 'established_year', 'operating_hours',
                'total_rooms', 'total_beds', 'icu_beds', 'emergency_available',
                'ambulance_available', 'doctors_list', 'special_doctors', 'specialties',
                'facilities', 'rating', 'total_reviews', 'reviews',
            ]);
        });
    }
};
