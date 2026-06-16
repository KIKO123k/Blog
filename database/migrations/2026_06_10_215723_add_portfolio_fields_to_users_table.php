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
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('email');
            $table->string('linkedin_url')->nullable()->after('bio');
            $table->string('github_url')->nullable()->after('linkedin_url');
            $table->string('phone')->nullable()->after('github_url');
            $table->string('cv_path')->nullable()->after('phone');
            $table->string('avatar_path')->nullable()->after('cv_path');
            $table->string('filiere')->nullable()->after('avatar_path');
            $table->unsignedSmallInteger('promotion')->nullable()->after('filiere');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio','linkedin_url','github_url','phone','cv_path','avatar_path','filiere','promotion']);
        });
    }
};
