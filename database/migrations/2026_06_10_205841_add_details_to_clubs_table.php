<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->string('slug')->unique()->after('acronym');
            $table->text('long_description')->nullable()->after('description');
            $table->string('president')->nullable()->after('long_description');
            $table->year('founded_year')->nullable()->after('president');
            $table->unsignedSmallInteger('members_count')->default(0)->after('founded_year');
            $table->string('instagram_url')->nullable()->after('members_count');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('facebook_url')->nullable()->after('linkedin_url');
            $table->string('website_url')->nullable()->after('facebook_url');
            $table->json('activities')->nullable()->after('website_url');
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn([
                'slug','long_description','president','founded_year','members_count',
                'instagram_url','linkedin_url','facebook_url','website_url','activities',
            ]);
        });
    }
};
