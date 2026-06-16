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
        Schema::table('formations', function (Blueprint $table) {
            if (!Schema::hasColumn('formations', 'video_url')) {
                $table->string('video_url')->nullable()->after('source_url');
            }
            if (!Schema::hasColumn('formations', 'video_path')) {
                $table->string('video_path')->nullable()->after('video_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            if (Schema::hasColumn('formations', 'video_url')) {
                $table->dropColumn('video_url');
            }
            if (Schema::hasColumn('formations', 'video_path')) {
                $table->dropColumn('video_path');
            }
        });
    }
};
