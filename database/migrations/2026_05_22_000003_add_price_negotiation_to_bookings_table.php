<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('proposed_price', 10, 2)->nullable()->after('notes');
            $table->decimal('counter_price', 10, 2)->nullable()->after('proposed_price');
            $table->string('price_status')->default('none')->after('counter_price');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['proposed_price', 'counter_price', 'price_status']);
        });
    }
};
