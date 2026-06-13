<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->boolean('profile_completed')->default(false)->after('reviews');
            $table->text('medicines')->nullable()->after('profile_completed');
        });

        DB::table('hospitals')->where('status', 'approved')->update(['profile_completed' => true]);

        DB::table('users')->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn(['profile_completed', 'medicines']);
        });
    }
};
