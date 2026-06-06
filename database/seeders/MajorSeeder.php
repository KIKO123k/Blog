<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run()
    {
        $majors = [
            [
                'title' => "Génie Informatique",
                'slug' => "genie-informatique",
                'description' => "Ingénieurs spécialisés en développement logiciel, algorithmes, bases de données, web et mobile.",
                'modules' => ["Algorithmique","Bases de données","Génie logiciel","Réseaux","IA","Dev web","Sécurité","Systèmes embarqués"],
                'access_conditions' => "CNC après Classes Préparatoires",
                'duration' => "3 ans"
            ],
            [
                'title' => "Réseaux et Systèmes de Télécommunications",
                'slug' => "reseaux-et-systemes-de-telecommunications",
                'description' => "Ingénieurs en réseaux, télécommunications, cybersécurité et systèmes distribués.",
                'modules' => ["TCP/IP","Télécommunications","Cybersécurité","Cloud","IoT","Administration systèmes"],
                'access_conditions' => "CNC après Classes Préparatoires",
                'duration' => "3 ans"
            ],
            [
                'title' => "Génie Industriel",
                'slug' => "genie-industriel",
                'description' => "Optimisation production, supply chain, qualité et automatisation industrielle.",
                'modules' => ["Gestion de production","Logistique","Lean","ERP/SAP","Qualité","Supply Chain"],
                'access_conditions' => "CNC après Classes Préparatoires",
                'duration' => "3 ans"
            ],
            [
                'title' => "Génie Électrique",
                'slug' => "genie-electrique",
                'description' => "Électrotechnique, électronique de puissance, machines électriques et automatique.",
                'modules' => ["Électrotechnique","Électronique de puissance","Automatique","Signal","Énergies renouvelables"],
                'access_conditions' => "CNC après Classes Préparatoires",
                'duration' => "3 ans"
            ],
            [
                'title' => "Génie Civil",
                'slug' => "genie-civil",
                'description' => "Construction, structures, hydraulique et gestion de projets BTP.",
                'modules' => ["Béton armé","Structures","Hydraulique","Mécanique des sols","BTP","Topographie"],
                'access_conditions' => "CNC après Classes Préparatoires",
                'duration' => "3 ans"
            ],
            [
                'title' => "Énergies Renouvelables",
                'slug' => "energies-renouvelables",
                'description' => "Solaire, éolien, hydraulique et gestion des systèmes énergétiques durables.",
                'modules' => ["Solaire","Éolien","Smart Grid","Stockage","Efficacité énergétique"],
                'access_conditions' => "CNC après Classes Préparatoires",
                'duration' => "3 ans"
            ]
        ];

        foreach ($majors as $majorData) {
            Major::updateOrCreate(['slug' => $majorData['slug']], $majorData);
        }
    }
}