<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member_applications', function (Blueprint $table) {
            $table->dropColumn(['cv_path', 'sample_path', 'extra_path']);
        });
    }

    public function down(): void
    {
        Schema::table('member_applications', function (Blueprint $table) {
            $table->string('cv_path')->nullable()->after('answer_bgc');
            $table->string('sample_path')->nullable()->after('cv_path');
            $table->string('extra_path')->nullable()->after('sample_path');
        });
    }
};
