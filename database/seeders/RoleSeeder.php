<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Utilisateur',
                'slug' => UserRole::USER->value,
                'description' => 'Rôle par défaut pour tous les utilisateurs enregistrés.',
            ],
            [
                'name' => 'Auteur',
                'slug' => UserRole::AUTHOR->value,
                'description' => 'Utilisateurs pouvant créer et publier du contenu (articles, commentaires).',
            ],
            [
                'name' => 'Administrateur',
                'slug' => UserRole::ADMIN->value,
                'description' => 'Accès complet à toutes les fonctionnalités du site.',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}