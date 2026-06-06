<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category'); // 'cycle_ingenieur', 'preparatoire', 'formation_continue', 'doctorat'
            $table->string('type')->nullable(); // e.g. 'ingenieur', 'licence', 'master'
            $table->text('description');
            $table->json('objectifs')->nullable();
            $table->json('competences')->nullable();
            $table->json('debouches')->nullable();
            $table->json('programme')->nullable(); // semesters => modules
            $table->json('acces')->nullable();      // admission conditions
            $table->json('partenariats')->nullable(); // double diplôme schools
            $table->string('source_url');
            $table->integer('duree_annees')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
