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
        // No schema changes needed here; the slug column is already added in a previous migration.
        // Backfill slugs for existing posts using a safe chunked approach.
        \App\Models\Post::whereNull('slug')
            ->orderBy('id')
            ->chunk(100, function ($posts) {
                foreach ($posts as $post) {
                    $post->slug = \Illuminate\Support\Str::slug($post->title);
                    $post->save();
                }
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for backfilled slugs.
    }
};
