<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Modèles d'événements par thème (le club est choisi par acronyme)
        $events = [
            'ADE ENSAK' => [
                ['title' => "Forum des Entreprises ENSAK", 'type' => 'conference', 'location' => 'Amphi A', 'in' => 14, 'desc' => "Rencontrez les entreprises partenaires, déposez vos CV et décrochez des stages."],
                ['title' => "Soirée d'intégration des nouveaux", 'type' => 'social', 'location' => 'Esplanade ENSAK', 'in' => 5, 'desc' => "Accueil festif des nouveaux étudiants : jeux, musique et networking."],
            ],
            'CME' => [
                ['title' => "Atelier Arduino & Capteurs", 'type' => 'atelier', 'location' => 'Labo Mécatronique', 'in' => 7, 'desc' => "Initiation pratique au prototypage avec Arduino, capteurs et actionneurs."],
                ['title' => "Compétition de robots suiveurs de ligne", 'type' => 'competition', 'location' => 'Hall Technique', 'in' => 21, 'desc' => "Concevez et programmez un robot autonome. Lots à gagner !"],
            ],
            'CRER' => [
                ['title' => "Workshop Panneaux Solaires", 'type' => 'atelier', 'location' => 'Labo Énergies', 'in' => 10, 'desc' => "Comprendre et dimensionner une installation photovoltaïque."],
            ],
            'ENACTUS' => [
                ['title' => "Bootcamp Entrepreneuriat Social", 'type' => 'atelier', 'location' => 'Salle de conférence', 'in' => 12, 'desc' => "Transformez une idée en projet à impact en 48h."],
                ['title' => "Pitch Day Enactus", 'type' => 'competition', 'location' => 'Amphi B', 'in' => 28, 'desc' => "Présentez votre projet devant un jury de professionnels."],
            ],
            'ANARUZ' => [
                ['title' => "Conférence Leadership & Soft Skills", 'type' => 'conference', 'location' => 'Amphi A', 'in' => 9, 'desc' => "Développez votre leadership avec des intervenants inspirants."],
            ],
            'CIEL' => [
                ['title' => "Visite Usine — Lean Manufacturing", 'type' => 'social', 'location' => 'Atlantic Free Zone', 'in' => 18, 'desc' => "Découvrez le Lean en conditions réelles dans une usine partenaire."],
                ['title' => "Atelier Six Sigma (Green Belt)", 'type' => 'atelier', 'location' => 'Salle GI-3', 'in' => 25, 'desc' => "Méthode DMAIC et outils statistiques pour l'amélioration continue."],
            ],
        ];

        // Un événement passé pour la démo
        $pastDays = -8;

        foreach ($events as $acronym => $list) {
            $club = Club::where('acronym', $acronym)->first();
            if (!$club) continue;

            foreach ($list as $e) {
                Event::updateOrCreate(
                    ['club_id' => $club->id, 'title' => $e['title']],
                    [
                        'description' => $e['desc'],
                        'location'    => $e['location'],
                        'type'        => $e['type'],
                        'starts_at'   => now()->addDays($e['in'])->setTime(14, 30),
                        'ends_at'     => now()->addDays($e['in'])->setTime(17, 0),
                    ]
                );
            }

            // un événement passé par club
            Event::updateOrCreate(
                ['club_id' => $club->id, 'title' => "Réunion de bureau — {$acronym}"],
                [
                    'description' => "Réunion mensuelle du bureau pour planifier les activités.",
                    'location'    => 'Local du club',
                    'type'        => 'social',
                    'starts_at'   => now()->addDays($pastDays)->setTime(16, 0),
                    'ends_at'     => now()->addDays($pastDays)->setTime(18, 0),
                ]
            );
        }
    }
}
