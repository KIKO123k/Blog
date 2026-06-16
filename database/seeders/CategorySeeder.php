<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Programmation',          'slug' => 'programmation'],
            ['name' => 'Mathématiques & Sciences','slug' => 'mathematiques-sciences'],
            ['name' => 'Intelligence Artificielle','slug' => 'intelligence-artificielle'],
            ['name' => 'Réseaux & Cybersécurité', 'slug' => 'reseaux-cybersecurite'],
            ['name' => 'Génie Industriel',        'slug' => 'genie-industriel'],
            ['name' => 'Énergie & Électronique',  'slug' => 'energie-electronique'],
            ['name' => 'Cloud & DevOps',          'slug' => 'cloud-devops'],
            ['name' => 'Compétences Transverses', 'slug' => 'competences-transverses'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], ['name' => $cat['name']]);
        }
    }
}
