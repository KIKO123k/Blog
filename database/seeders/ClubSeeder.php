<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        Club::truncate();

        $clubs = [
            [
                'name'             => 'Association des Étudiants de l\'ENSA Kénitra',
                'acronym'          => 'ADE ENSAK',
                'slug'             => 'ade-ensak',
                'theme'            => 'leadership',
                'description'      => 'Le bureau officiel des étudiants de l\'ENSA Kénitra. Organisation d\'événements, représentation des étudiants et animation de la vie associative.',
                'long_description' => 'L\'ADE ENSAK est la voix officielle des étudiants de l\'École Nationale des Sciences Appliquées de Kénitra. Elle coordonne l\'ensemble des clubs et associations, organise des événements culturels et sportifs, et assure la liaison entre les étudiants et l\'administration. L\'association gère la plateforme adensak.com qui centralise toutes les activités parascolaires de l\'école.',
                'president'        => 'Bureau Exécutif ADE ENSAK',
                'founded_year'     => 2011,
                'members_count'    => 500,
                'instagram_url'    => 'https://www.instagram.com/adeensak/',
                'linkedin_url'     => 'https://fr.linkedin.com/school/ensakenitra/',
                'facebook_url'     => 'https://www.facebook.com/AEIENSAK/',
                'website_url'      => 'https://www.adensak.com',
                'activities'       => [
                    'Organisation de la Semaine de l\'Ingénieur',
                    'Forum entreprises & recrutement',
                    'Compétitions sportives inter-filières',
                    'Soirées culturelles et artistiques',
                    'Gestion des clubs étudiants',
                ],
            ],
            [
                'name'             => 'Club Mécatronique ENSA Kénitra',
                'acronym'          => 'CME',
                'slug'             => 'club-mecatronique',
                'theme'            => 'robotics',
                'description'      => 'Depuis 2017, plus de 250 étudiants réunis autour de la robotique, l\'électronique et l\'intelligence artificielle. Compétitions nationales et projets innovants.',
                'long_description' => 'Le Club Mécatronique de l\'ENSA Kénitra rassemble depuis 2017 les passionnés de robotique, d\'électronique et d\'intelligence artificielle. Le club réalise des projets pluridisciplinaires mêlant mécanique, informatique embarquée et automatisme. Il participe activement aux compétitions nationales de robotique et organise des workshops ouverts à tous les niveaux.',
                'president'        => 'Club Mécatronique ENSAK',
                'founded_year'     => 2017,
                'members_count'    => 250,
                'instagram_url'    => 'https://www.instagram.com/club_mecatronique_ensak/',
                'linkedin_url'     => 'https://fr.linkedin.com/school/ensakenitra/',
                'facebook_url'     => null,
                'website_url'      => 'https://mecatronique-ensak.com',
                'activities'       => [
                    'Conception et programmation de robots',
                    'Compétitions nationales de robotique',
                    'Workshops électronique & Arduino',
                    'Projets IA embarquée',
                    'Visites industrielles',
                ],
            ],
            [
                'name'             => 'Club Robotique & Énergies Renouvelables ENSA Kénitra',
                'acronym'          => 'CRER',
                'slug'             => 'crer-ensak',
                'theme'            => 'industrial',
                'description'      => 'Créé en mars 2011, le CRER est un espace d\'interaction et d\'ouverture sur le monde industriel combinant robotique et énergies renouvelables.',
                'long_description' => 'Le Club Robotique & Énergies Renouvelables (CRER) de l\'ENSA Kénitra a été fondé en mars 2011 par et pour les étudiants de l\'école. Il constitue un espace de travail, d\'interaction et d\'ouverture sur le monde industriel. Le club mène des projets combinant robotique, automatisme et solutions d\'énergie renouvelable, en partenariat avec des entreprises du secteur.',
                'president'        => 'CRER ENSAK',
                'founded_year'     => 2011,
                'members_count'    => 120,
                'instagram_url'    => null,
                'linkedin_url'     => 'https://www.linkedin.com/company/crerensak',
                'facebook_url'     => null,
                'website_url'      => null,
                'activities'       => [
                    'Projets robotique industrielle',
                    'Études de systèmes solaires et éoliens',
                    'Partenariats entreprises énergétiques',
                    'Conférences et séminaires techniques',
                    'Participation aux salons industriels',
                ],
            ],
            [
                'name'             => 'Enactus ENSA Kénitra',
                'acronym'          => 'ENACTUS',
                'slug'             => 'enactus-ensak',
                'theme'            => 'social',
                'description'      => 'Réseau mondial d\'entrepreneuriat social. Les étudiants d\'ENSAK créent des projets à impact économique et social pour les communautés locales.',
                'long_description' => 'Enactus ENSA Kénitra fait partie du réseau mondial Enactus, présent dans plus de 36 pays. Le club réunit des étudiants-entrepreneurs qui conçoivent et déploient des projets à impact social, économique et environnemental positif pour les communautés locales. Les équipes participent aux compétitions nationales Enactus Morocco et représentent l\'école au niveau international.',
                'president'        => 'Enactus ENSAK',
                'founded_year'     => 2015,
                'members_count'    => 80,
                'instagram_url'    => 'https://www.instagram.com/enactus_ensa_kenitra/',
                'linkedin_url'     => 'https://fr.linkedin.com/school/ensakenitra/',
                'facebook_url'     => null,
                'website_url'      => null,
                'activities'       => [
                    'Projets d\'entrepreneuriat social',
                    'Compétitions nationales Enactus Morocco',
                    'Accompagnement de porteurs de projets',
                    'Ateliers design thinking',
                    'Partenariats avec ONGs locales',
                ],
            ],
            [
                'name'             => 'Club Anaruz ENSA Kénitra',
                'acronym'          => 'ANARUZ',
                'slug'             => 'anaruz-ensak',
                'theme'            => 'social',
                'description'      => 'Organisation humanitaire et sociale fondée en 2011. Aide aux populations vulnérables, caravanes médicales et distribution de fournitures scolaires.',
                'long_description' => 'Le Club Anaruz est une association humanitaire et sociale à but non lucratif fondée le 10 octobre 2011. Son objectif est d\'apporter une aide concrète aux populations vulnérables en améliorant leurs conditions de vie. Le club organise des caravanes humanitaires, distribue des fournitures scolaires aux enfants défavorisés, et effectue des visites régulières dans les hôpitaux et les centres sociaux.',
                'president'        => 'BOUISS Saad',
                'founded_year'     => 2011,
                'members_count'    => 60,
                'instagram_url'    => 'https://www.instagram.com/anaruz.ensak/',
                'linkedin_url'     => 'https://fr.linkedin.com/school/ensakenitra/',
                'facebook_url'     => null,
                'website_url'      => null,
                'activities'       => [
                    'Caravanes humanitaires',
                    'Distribution de fournitures scolaires',
                    'Visites dans les hôpitaux',
                    'Collectes de dons et fundraising',
                    'Partenariats avec centres sociaux',
                ],
            ],
            [
                'name'             => 'Club Génie Industriel & Logistique ENSA Kénitra',
                'acronym'          => 'CIEL',
                'slug'             => 'ciel-ensak',
                'theme'            => 'industrial',
                'description'      => 'Le club des étudiants en Génie Industriel. Visites d\'entreprises, conférences techniques et projets d\'amélioration continue et de logistique.',
                'long_description' => 'Le Club CIEL (Club of Industrial Engineering and Logistics) regroupe les étudiants passionnés par le génie industriel, la supply chain et la logistique. Il organise des visites d\'entreprises, des conférences avec des professionnels du secteur et des projets d\'amélioration continue. Le club prépare ses membres aux réalités du monde industriel marocain et international.',
                'president'        => 'CIEL ENSAK',
                'founded_year'     => 2018,
                'members_count'    => 90,
                'instagram_url'    => 'https://www.instagram.com/cielensak/',
                'linkedin_url'     => 'https://fr.linkedin.com/school/ensakenitra/',
                'facebook_url'     => null,
                'website_url'      => null,
                'activities'       => [
                    'Visites d\'entreprises industrielles',
                    'Conférences supply chain & logistique',
                    'Projets Lean Manufacturing',
                    'Simulations de gestion de production',
                    'Préparation aux stages industriels',
                ],
            ],
        ];

        foreach ($clubs as $club) {
            Club::create($club);
        }
    }
}
