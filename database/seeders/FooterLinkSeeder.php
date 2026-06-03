<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterLink;

class FooterLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            ['title' => 'Politique de confidentialité', 'url' => '#', 'order' => 1],
            ['title' => "À propos d'EduBlog", 'url' => '#', 'order' => 2],
            ['title' => 'Avertissements', 'url' => '#', 'order' => 3],
            ['title' => 'Contact', 'url' => '#', 'order' => 4],
            ['title' => 'Mentions légales', 'url' => '#', 'order' => 5],
            ['title' => 'Code de conduite', 'url' => '#', 'order' => 6],
            ['title' => 'Développeurs', 'url' => '#', 'order' => 7],
            ['title' => 'Statistiques', 'url' => '#', 'order' => 8],
            ['title' => 'Cookies', 'url' => route('cookies'), 'order' => 9],
            ['title' => 'Version mobile', 'url' => '#', 'order' => 10],
        ];

        foreach ($links as $link) {
            FooterLink::updateOrCreate(
                ['title' => $link['title']],
                ['url' => $link['url'], 'order' => $link['order']]
            );
        }
    }
}
