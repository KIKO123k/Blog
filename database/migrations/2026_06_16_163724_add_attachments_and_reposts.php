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
        Schema::table('messages', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('body');
            $table->string('attachment_type')->nullable()->after('attachment_path'); // image | pdf
            $table->string('attachment_name')->nullable()->after('attachment_type');
            $table->foreignId('shared_post_id')->nullable()->after('attachment_name')
                ->constrained('posts')->nullOnDelete();
            $table->text('body')->nullable()->change(); // le corps devient optionnel (pièce jointe / partage seuls)
        });

        // Articles repostés sur le portfolio
        Schema::create('reposts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reposts');
        Schema::table('messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('shared_post_id');
            $table->dropColumn(['attachment_path', 'attachment_type', 'attachment_name']);
        });
    }
};
