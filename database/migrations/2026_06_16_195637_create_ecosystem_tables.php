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
        // --- Lost & Found : objets perdus / trouvés ---
        Schema::create('lost_found_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['lost', 'found']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->default('autre'); // electronique, documents, vetements, cles, autre
            $table->string('location')->nullable();
            $table->date('item_date')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status', ['open', 'resolved'])->default('open');
            $table->timestamps();
        });

        // --- Find Teammates : annonces de recherche de coéquipiers ---
        Schema::create('team_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('skills_needed')->nullable(); // compétences recherchées (CSV)
            $table->string('filiere')->nullable();
            $table->unsignedTinyInteger('team_size')->default(2);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        // --- Career Center : offres de stages / emplois ---
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('company');
            $table->enum('type', ['stage', 'pfe', 'emploi', 'alternance'])->default('stage');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('apply_url')->nullable();
            $table->string('domain')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
        Schema::dropIfExists('team_posts');
        Schema::dropIfExists('lost_found_items');
    }
};
