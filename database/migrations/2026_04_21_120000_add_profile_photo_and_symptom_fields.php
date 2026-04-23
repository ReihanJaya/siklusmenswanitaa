<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('remember_token');
        });

        Schema::table('symptom_logs', function (Blueprint $table) {
            $table->integer('fatigue')->nullable()->after('mood');
            $table->string('emotions')->nullable()->after('fatigue');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_photo');
        });

        Schema::table('symptom_logs', function (Blueprint $table) {
            $table->dropColumn(['fatigue', 'emotions']);
        });
    }
};
