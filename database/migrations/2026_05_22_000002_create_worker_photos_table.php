<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_profile_id')->constrained()->onDelete('cascade');
            $table->string('photo_path');
            $table->string('caption')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_photos');
    }
};
