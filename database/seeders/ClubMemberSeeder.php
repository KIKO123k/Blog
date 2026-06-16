<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClubMemberSeeder extends Seeder
{
    public function run(): void
    {
        // --- Pool de profils étudiants (démo) avec portfolio rempli ---
        $pool = [
            ['name' => 'Aya Benjelloun',   'filiere' => 'Génie Informatique'],
            ['name' => 'Mehdi El Amrani',  'filiere' => 'Génie Mécatronique'],
            ['name' => 'Salma Bennani',    'filiere' => 'Réseaux et Systèmes de Télécommunications'],
            ['name' => 'Othmane Rachidi',  'filiere' => 'Génie Industriel'],
            ['name' => 'Ghita Lahlou',     'filiere' => 'Génie Électrique'],
            ['name' => 'Anas Berrada',     'filiere' => 'Génie Énergétique et Énergies Renouvelables'],
            ['name' => 'Imane Saidi',      'filiere' => 'Génie Informatique'],
            ['name' => 'Youssef Naciri',   'filiere' => 'Génie Mécatronique'],
            ['name' => 'Nada El Fassi',    'filiere' => 'Réseaux et Systèmes de Télécommunications'],
            ['name' => 'Hamza Ouazzani',   'filiere' => 'Génie Industriel'],
            ['name' => 'Lina Chraibi',     'filiere' => 'Génie Électrique'],
            ['name' => 'Reda Tahiri',      'filiere' => 'Génie Énergétique et Énergies Renouvelables'],
            ['name' => 'Sara Belkadi',     'filiere' => 'Génie Informatique'],
            ['name' => 'Walid Mansouri',   'filiere' => 'Génie Mécatronique'],
            ['name' => 'Kenza Idrissi',    'filiere' => 'Réseaux et Systèmes de Télécommunications'],
            ['name' => 'Bilal Sefrioui',   'filiere' => 'Génie Industriel'],
        ];

        $users = [];
        foreach ($pool as $i => $p) {
            $slug  = $this->emailSlug($p['name']);
            $promo = 2026 + ($i % 3); // 2026, 2027, 2028
            $users[] = User::firstOrCreate(
                ['email' => $slug . '@uit.ac.ma'],
                [
                    'name'              => $p['name'],
                    'password'          => Hash::make('password'),
                    'account_type'      => 'student',
                    'filiere'           => $p['filiere'],
                    'promotion'         => $promo,
                    'bio'               => "Étudiant(e) en {$p['filiere']} à l'ENSA Kénitra, passionné(e) par l'innovation et la vie associative.",
                    'linkedin_url'      => 'https://www.linkedin.com/in/' . $slug,
                    'phone'             => '06' . str_pad((string) (10000000 + $i * 137), 8, '0', STR_PAD_LEFT),
                    'phone_privacy'     => 'friends',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Rôles du bureau (avec position d'affichage)
        $bureauRoles = [
            ['role' => 'Président(e)',               'position' => 1],
            ['role' => 'Vice-Président(e)',          'position' => 2],
            ['role' => 'Secrétaire Général(e)',      'position' => 3],
            ['role' => 'Trésorier(ère)',             'position' => 4],
            ['role' => 'Responsable Communication',  'position' => 5],
        ];

        $clubs = Club::orderBy('id')->get();
        $n = count($users);

        foreach ($clubs as $ci => $club) {
            $sync = [];

            // 5 membres de bureau (décalage par club pour varier les profils)
            foreach ($bureauRoles as $bi => $br) {
                $u = $users[($ci * 5 + $bi) % $n];
                $sync[$u->id] = ['role' => $br['role'], 'is_bureau' => true, 'position' => $br['position']];
            }

            // 4 adhérents (en évitant les doublons déjà dans le bureau)
            $added = 0; $k = $ci * 3 + 2;
            while ($added < 4 && count($sync) < $n) {
                $u = $users[$k % $n];
                if (!isset($sync[$u->id])) {
                    $sync[$u->id] = ['role' => 'Adhérent(e)', 'is_bureau' => false, 'position' => 10 + $added];
                    $added++;
                }
                $k++;
            }

            $club->members()->sync($sync);
        }

        $this->command->info('ClubMemberSeeder : ' . $clubs->count() . ' clubs peuplés (bureau + adhérents).');
    }

    private function emailSlug(string $name): string
    {
        $name = strtr($name, [
            'é'=>'e','è'=>'e','ê'=>'e','à'=>'a','â'=>'a','î'=>'i','ï'=>'i','ô'=>'o','û'=>'u','ç'=>'c',
        ]);
        return strtolower(str_replace(' ', '.', trim($name)));
    }
}
