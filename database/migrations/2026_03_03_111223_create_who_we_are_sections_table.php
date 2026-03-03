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
        Schema::create('who_we_are_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique(); // e.g. 'hero', 'story', 'founding_team', etc.
            $table->json('data');                 // section-specific JSON payload
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('who_we_are_sections');
    }
};
