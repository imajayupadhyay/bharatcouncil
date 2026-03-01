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
        Schema::create('member_applications', function (Blueprint $table) {
            $table->id();

            // Step 1 — Profile
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('city');
            $table->string('designation');
            $table->string('organisation')->nullable();
            $table->string('membership_type');
            $table->string('mode');
            $table->text('background');
            $table->string('contribution_area');
            $table->string('board_relation')->nullable();

            // Step 2 — Reflective answers
            $table->text('answer_governance')->nullable();
            $table->text('answer_contribution')->nullable();
            $table->text('answer_reform')->nullable();
            $table->text('answer_bgc')->nullable();

            // Step 3 — Documents (stored paths)
            $table->string('cv_path')->nullable();
            $table->string('sample_path')->nullable();
            $table->string('extra_path')->nullable();
            $table->text('referees')->nullable();
            $table->text('additional_notes')->nullable();

            // Admin management
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_applications');
    }
};
