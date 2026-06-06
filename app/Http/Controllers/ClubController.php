<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = [
            ['name' => 'Club Informatique', 'image' => 'informatique.jpg', 'description' => 'Innovation logicielle et développement web.'],
            ['name' => 'Club Robotique', 'image' => 'robotique.jpg', 'description' => 'Conception et programmation de systèmes autonomes.'],
            ['name' => 'Club IA & Data Science', 'image' => 'ia.jpg', 'description' => 'Exploration des algorithmes et du Big Data.'],
            ['name' => 'Club Cybersécurité', 'image' => 'cybersecurite.jpg', 'description' => 'Protection des systèmes et lutte contre les cybermenaces.'],
            ['name' => 'Club Réseaux & Télécommunications', 'image' => 'reseaux.jpg', 'description' => 'Gestion des infrastructures et protocoles de communication.'],
            ['name' => 'Club Génie Industriel', 'image' => 'industriel.jpg', 'description' => 'Optimisation des processus et logistique moderne.'],
            ['name' => 'Club Énergies Renouvelables', 'image' => 'energies.jpg', 'description' => 'Solutions durables pour un avenir énergétique vert.'],
            ['name' => 'Club Entrepreneuriat', 'image' => 'entrepreneuriat.jpg', 'description' => 'De l\'idée au projet : créez votre propre startup.'],
            ['name' => 'Club Développement Personnel', 'image' => 'developpement.jpg', 'description' => 'Soft skills, leadership et épanouissement personnel.'],
            ['name' => 'Club Sport', 'image' => 'sport.jpg', 'description' => 'Compétitions et bien-être physique pour tous les étudiants.'],
            ['name' => 'Club Culture & Arts', 'image' => 'culture.jpg', 'description' => 'Théâtre, musique et expression artistique sur le campus.'],
            ['name' => 'Club Social & Humanitaire', 'image' => 'humanitaire.jpg', 'description' => 'Actions solidaires et aide aux populations locales.'],
            ['name' => 'Club Média & Communication', 'image' => 'media.jpg', 'description' => 'Journalisme, radio et présence digitale de l\'école.'],
        ];

        return view('clubs', compact('clubs'));
    }
}