<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('worker_profiles', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('is_available');
            $table->boolean('instant_booking')->default(false)->after('is_verified');
            $table->string('response_time')->nullable()->after('instant_booking');
            $table->json('badges')->nullable()->after('response_time');
        });
    }

    public function down(): void
    {
        Schema::table('worker_profiles', function (Blueprint $table) {
            $table->dropColumn(['is_verified', 'instant_booking', 'response_time', 'badges']);
        });
    }
};
