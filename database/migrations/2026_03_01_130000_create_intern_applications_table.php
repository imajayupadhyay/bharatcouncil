<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intern_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 50);
            $table->string('city');
            $table->string('institution');
            $table->string('programme');
            $table->string('discipline');
            $table->string('grad_year', 20);
            $table->string('track');
            $table->string('cohort');
            $table->string('mode');
            $table->string('duration');
            $table->text('statement');
            $table->text('governance_problem')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intern_applications');
    }
};
