<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\LostFoundItem;
use App\Models\TeamPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class EcosystemSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('account_type', 'student')->take(6)->get();
        if ($students->isEmpty()) return;

        // --- Team posts ---
        $teams = [
            ['title' => 'App mobile de covoiturage étudiant', 'description' => 'On cherche 2 développeurs Flutter et un designer pour un projet de covoiturage entre étudiants ENSA.', 'skills_needed' => 'Flutter, UI/UX, Firebase', 'filiere' => 'Génie Informatique', 'team_size' => 4],
            ['title' => 'Robot suiveur de ligne pour la compétition', 'description' => 'Équipe pour concevoir un robot autonome. Besoin de profils électronique et embarqué.', 'skills_needed' => 'Arduino, C, Électronique', 'filiere' => 'Génie Mécatronique', 'team_size' => 3],
            ['title' => 'Étude d\'optimisation logistique (PFE)', 'description' => 'Projet de fin d\'études sur l\'optimisation d\'une chaîne logistique. Cherche binôme motivé.', 'skills_needed' => 'Lean, Python, Excel', 'filiere' => 'Génie Industriel', 'team_size' => 2],
            ['title' => 'Plateforme web pour un club', 'description' => 'Développement d\'un site pour gérer les événements d\'un club. Stack Laravel.', 'skills_needed' => 'Laravel, MySQL, Tailwind', 'filiere' => 'Génie Informatique', 'team_size' => 3],
        ];
        foreach ($teams as $i => $t) {
            TeamPost::firstOrCreate(
                ['title' => $t['title']],
                array_merge($t, ['user_id' => $students[$i % $students->count()]->id])
            );
        }

        // --- Lost & Found ---
        $items = [
            ['type' => 'lost', 'title' => 'Carte étudiante perdue', 'category' => 'documents', 'location' => 'Bibliothèque', 'description' => 'Carte au nom d\'un étudiant de 3ème année, perdue près de la BU.'],
            ['type' => 'found', 'title' => 'Trousseau de clés trouvé', 'category' => 'cles', 'location' => 'Parking ENSA', 'description' => 'Trois clés avec un porte-clés rouge, trouvées sur le parking.'],
            ['type' => 'lost', 'title' => 'Calculatrice scientifique', 'category' => 'electronique', 'location' => 'Amphi B', 'description' => 'Casio fx-991, perdue après le cours de maths.'],
            ['type' => 'found', 'title' => 'Veste noire oubliée', 'category' => 'vetements', 'location' => 'Salle GI-3', 'description' => 'Veste taille M trouvée sur une chaise.'],
        ];
        foreach ($items as $i => $it) {
            LostFoundItem::firstOrCreate(
                ['title' => $it['title']],
                array_merge($it, ['user_id' => $students[$i % $students->count()]->id, 'item_date' => now()->subDays($i + 1)])
            );
        }

        // --- Job offers ---
        $admin = User::where('is_admin', true)->first();
        $offers = [
            ['title' => 'Stage PFE — Développeur Full-Stack', 'company' => 'Capgemini', 'type' => 'pfe', 'location' => 'Casablanca', 'domain' => 'Informatique', 'description' => 'Participez au développement d\'applications web modernes (React/Node). 6 mois.', 'apply_url' => 'https://www.capgemini.com/careers/'],
            ['title' => 'Stage — Ingénieur Réseaux', 'company' => 'Maroc Telecom', 'type' => 'stage', 'location' => 'Rabat', 'domain' => 'Télécoms', 'description' => 'Stage technique sur l\'infrastructure réseau et la supervision.', 'apply_url' => 'https://www.iam.ma'],
            ['title' => 'Alternance — Data Analyst', 'company' => 'OCP Group', 'type' => 'alternance', 'location' => 'Khouribga', 'domain' => 'Data', 'description' => 'Analyse de données industrielles, dashboards Power BI.', 'apply_url' => 'https://www.ocpgroup.ma'],
            ['title' => 'Emploi — Ingénieur Énergies Renouvelables', 'company' => 'Masen', 'type' => 'emploi', 'location' => 'Ouarzazate', 'domain' => 'Énergie', 'description' => 'Conception et suivi de projets solaires.', 'apply_url' => 'https://www.masen.ma'],
        ];
        foreach ($offers as $o) {
            JobOffer::firstOrCreate(
                ['title' => $o['title'], 'company' => $o['company']],
                array_merge($o, ['posted_by' => $admin?->id])
            );
        }
    }
}
