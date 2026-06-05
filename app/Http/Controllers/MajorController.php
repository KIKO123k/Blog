<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MajorController extends Controller
{
    // Simple static data; in a real app this could be a model.
    private $majors = [
        'reseaux-et-systemes-de-telecommunications' => [
            'title' => 'Réseaux et Systèmes de Télécommunications',
            'image' => 'images/major_telecom.png',
            'description' => 'Cette filière forme des ingénieurs spécialisés dans les réseaux informatiques, les télécommunications, la cybersécurité et les infrastructures numériques modernes.',
        ],
        'genie-informatique' => [
            'title' => 'Génie Informatique',
            'image' => 'images/major_informatique.png',
            'description' => 'Cette filière forme des ingénieurs en informatique, spécialisés dans le développement logiciel, les algorithmes, les bases de données et les technologies émergentes.',
        ],
        'genie-industriel' => [
            'title' => 'Génie Industriel',
            'image' => 'images/major_industriel.png',
            'description' => 'Cette filière forme des ingénieurs spécialisés dans l\'optimisation de la production, la gestion de la chaîne d\'approvisionnement, le contrôle qualité et l\'automatisation industrielle.',
        ],
        'genie-electrique' => [
            'title' => 'Génie Électrique',
            'image' => 'images/major_electrique.png',
            'description' => 'Cette filière forme des ingénieurs spécialisés dans les systèmes électriques, l\'électronique, les énergies renouvelables et la conception de systèmes embarqués.',
        ],
        'genie-mecatronique' => [
            'title' => 'Génie Mécatronique',
            'image' => 'images/major_mechatronique.png',
            'description' => 'Cette filière combine mécanique, électronique et informatique pour créer des machines intelligentes et des solutions d\'automatisation.',
        ],
        'genie-energetique-et-energies-renouvelables' => [
            'title' => 'Génie Énergétique et Énergies Renouvelables',
            'image' => 'images/major_energetique.png',
            'description' => 'Cette filière forme des ingénieurs capables de concevoir des solutions d\'énergie durable, d\'améliorer l\'efficacité énergétique et de gérer les ressources renouvelables.',
        ],
    ];

    /**
     * Show detail page for a major.
     */
    public function show(string $slug)
    {
        $data = $this->majors[$slug] ?? null;
        if (! $data) {
            abort(404);
        }
        return view('majors.show', compact('data'));
    }
}
?>
