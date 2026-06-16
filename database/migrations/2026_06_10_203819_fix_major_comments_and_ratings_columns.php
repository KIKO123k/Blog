<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix major_comments: add missing columns if they don't exist
        Schema::table('major_comments', function (Blueprint $table) {
            if (!Schema::hasColumn('major_comments', 'major_id')) {
                $table->foreignId('major_id')->constrained('formations')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('major_comments', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('major_comments', 'content')) {
                $table->text('content');
            }
        });

        // Fix major_ratings: add missing columns if they don't exist
        Schema::table('major_ratings', function (Blueprint $table) {
            if (!Schema::hasColumn('major_ratings', 'major_id')) {
                $table->foreignId('major_id')->constrained('formations')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('major_ratings', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('major_ratings', 'rating')) {
                $table->tinyInteger('rating');
            }
        });
    }

    public function down(): void
    {
        Schema::table('major_comments', function (Blueprint $table) {
            $table->dropForeign(['major_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['major_id', 'user_id', 'content']);
        });

        Schema::table('major_ratings', function (Blueprint $table) {
            $table->dropForeign(['major_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['major_id', 'user_id', 'rating']);
        });
    }
};
