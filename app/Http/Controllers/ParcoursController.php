<?php

namespace App\Http\Controllers;

/**
 * Présente l'offre de formation complète de l'ENSA Kénitra
 * (au-delà des 6 filières d'ingénieur affichées sur /majors) :
 * classe préparatoire, master, doctorat, double diplomation,
 * mobilité internationale et écoles partenaires.
 *
 * Données statiques (informations institutionnelles publiques de
 * l'ENSA Kénitra) — volontairement séparées de la table `formations`
 * pour ne pas impacter la page Filière existante.
 */
class ParcoursController extends Controller
{
    public function index()
    {
        $programs = array_values($this->programs());
        $partners = $this->partners();

        return view('parcours.index', compact('programs', 'partners'));
    }

    public function show(string $slug)
    {
        // Le cycle ingénieur renvoie vers la page des 6 filières existante.
        if ($slug === 'cycle-ingenieur') {
            return redirect()->route('majors.index');
        }

        $programs = $this->programs();
        abort_unless(isset($programs[$slug]), 404);

        return view('parcours.show', ['p' => $programs[$slug]]);
    }

    /* ------------------------------------------------------------------ */

    /**
     * Toutes les formations, indexées par slug.
     * Champs « carte » (title, subtitle, description, points…) + champs
     * « page détail » (intro, sections).
     */
    private function programs(): array
    {
        return [
            'classe-preparatoire' => [
                'slug' => 'classe-preparatoire', 'icon' => 'book', 'color' => '#6366f1', 'badge' => '2 ans',
                'title' => 'Classe Préparatoire', 'subtitle' => 'Cycle préparatoire intégré',
                'description' => "Les deux premières années (AP1 & AP2) posent les fondations scientifiques solides en mathématiques, physique, informatique et sciences de l'ingénieur, avant l'accès au cycle ingénieur.",
                'points' => ['Mathématiques & Physique', 'Informatique & Algorithmique', 'Sciences de l\'ingénieur', 'Langues & Communication'],
                'intro' => "Le cycle préparatoire intégré de l'ENSA Kénitra s'étend sur deux années (AP1 et AP2). Il a pour but de doter l'étudiant des bases scientifiques et méthodologiques indispensables avant d'intégrer l'une des six filières d'ingénieur d'État de l'école.",
                'sections' => [
                    ['title' => 'Objectifs', 'items' => [
                        'Acquérir des fondations solides en sciences fondamentales',
                        'Développer le raisonnement analytique et la rigueur scientifique',
                        'Maîtriser les outils mathématiques et informatiques de l\'ingénieur',
                        'Préparer une orientation réussie vers le cycle ingénieur',
                    ]],
                    ['title' => 'Matières principales', 'items' => [
                        'Analyse & Algèbre', 'Physique (mécanique, électricité, thermodynamique)',
                        'Informatique & Algorithmique', 'Sciences industrielles de l\'ingénieur',
                        'Langues étrangères (français, anglais)', 'Techniques d\'expression & communication',
                    ]],
                    ['title' => 'Accès & débouchés', 'items' => [
                        'Accès post-bac via le Concours National Commun (CNC) / sélection sur dossier',
                        'Profils scientifiques (Sciences Maths, PC, SVT…)',
                        'Passage au cycle ingénieur après validation des deux années',
                    ]],
                ],
            ],
            'cycle-ingenieur' => [
                'slug' => 'cycle-ingenieur', 'icon' => 'gear', 'color' => '#059669', 'badge' => '3 ans',
                'title' => 'Cycle Ingénieur', 'subtitle' => '6 filières d\'excellence',
                'description' => "Après le cycle préparatoire, l'étudiant choisit l'une des 6 filières d'ingénieur d'État pour 3 années de spécialisation et de projets professionnalisants.",
                'points' => ['Génie Informatique', 'Réseaux & Télécoms', 'Génie Industriel', 'Génie Électrique / Mécatronique / Énergétique'],
                // pas de page détail : renvoie vers /majors
            ],
            'master' => [
                'slug' => 'master', 'icon' => 'cap', 'color' => '#0ea5e9', 'badge' => 'Bac+5',
                'title' => 'Master Universitaire Spécialisé', 'subtitle' => 'Formation initiale & continue',
                'description' => "Des masters spécialisés et licences professionnelles permettent d'approfondir un domaine pointu et d'ouvrir vers la recherche ou l'expertise métier, en formation initiale comme continue.",
                'points' => ['Spécialisations pointues', 'Ouverture vers la R&D', 'Accessible en formation continue', 'Encadrement par des experts'],
                'intro' => "L'ENSA Kénitra propose des masters universitaires spécialisés et des licences professionnelles, en formation initiale et continue. Ces parcours permettent d'approfondir un domaine ciblé et d'acquérir une expertise directement valorisable sur le marché du travail ou en recherche.",
                'sections' => [
                    ['title' => 'Objectifs', 'items' => [
                        'Approfondir un domaine technique ou scientifique pointu',
                        'Développer une double compétence métier / management',
                        'Ouvrir la voie vers la recherche (doctorat) ou l\'expertise',
                    ]],
                    ['title' => 'Atouts', 'items' => [
                        'Spécialisations alignées sur les besoins de l\'industrie',
                        'Accessible en formation continue (professionnels)',
                        'Encadrement par des enseignants-chercheurs et experts',
                        'Projets et stages en entreprise',
                    ]],
                    ['title' => 'Conditions d\'accès', 'items' => [
                        'Titulaires d\'une licence (ou équivalent) dans un domaine compatible',
                        'Sélection sur dossier et/ou entretien',
                    ]],
                ],
            ],
            'doctorat' => [
                'slug' => 'doctorat', 'icon' => 'atom', 'color' => '#d97706', 'badge' => 'Bac+8',
                'title' => 'Doctorat (CEDoc)', 'subtitle' => 'Cycle doctoral & recherche',
                'description' => "Le Centre d'Études Doctorales accueille plus de 400 doctorants. Les laboratoires mènent une recherche appliquée en lien étroit avec l'industrie.",
                'points' => ['+400 doctorants', 'Laboratoires de recherche', 'Thèses en cotutelle', 'Publications internationales'],
                'intro' => "Le Centre d'Études Doctorales (CEDoc) de l'ENSA Kénitra encadre plus de 400 doctorants. Adossé à des laboratoires de recherche dont le laboratoire « Génie des Systèmes », il mène une recherche appliquée en lien étroit avec le tissu industriel et des partenaires internationaux.",
                'sections' => [
                    ['title' => 'Déroulement', 'items' => [
                        'Durée de 3 à 5 ans après le master',
                        'Travaux de recherche encadrés au sein d\'un laboratoire',
                        'Publications scientifiques et soutenance de thèse',
                    ]],
                    ['title' => 'Recherche & partenariats', 'items' => [
                        '+400 doctorants encadrés',
                        'Thèses en cotutelle avec des institutions étrangères (ex : INSA Rouen)',
                        'Collaborations avec l\'industrie (Atlantic Free Zone, MAScIR…)',
                    ]],
                    ['title' => 'Débouchés', 'items' => [
                        'Enseignant-chercheur universitaire',
                        'Chercheur en R&D / ingénieur expert',
                        'Consultant scientifique de haut niveau',
                    ]],
                ],
            ],
            'double-diplomation' => [
                'slug' => 'double-diplomation', 'icon' => 'diploma', 'color' => '#db2777', 'badge' => 'International',
                'title' => 'Double Diplomation', 'subtitle' => 'Un cursus, deux diplômes',
                'description' => "Grâce à ses partenariats, l'ENSA Kénitra permet d'obtenir un double diplôme — notamment avec l'ESIX Normandie (UNICAEN, France) en Mécatronique et Systèmes Nomades.",
                'points' => ['Diplôme ENSA + diplôme partenaire', 'ESIX Normandie – UNICAEN', 'Reconnaissance internationale', 'Insertion à l\'étranger facilitée'],
                'intro' => "Le programme de double diplomation permet à l'étudiant d'obtenir, au cours d'un même parcours, le diplôme d'ingénieur de l'ENSA Kénitra ainsi que le diplôme d'une école partenaire — en particulier l'ESIX Normandie (Université de Caen) en Mécatronique et Systèmes Nomades.",
                'sections' => [
                    ['title' => 'Principe', 'items' => [
                        'Un cursus, deux diplômes reconnus',
                        'Une partie de la scolarité réalisée chez le partenaire',
                        'Reconnaissance académique internationale',
                    ]],
                    ['title' => 'Partenaire de référence', 'items' => [
                        'ESIX Normandie — Université de Caen (UNICAEN), France',
                        'Spécialités : Mécatronique et Systèmes Nomades',
                    ]],
                    ['title' => 'Avantages', 'items' => [
                        'Profil très recherché par les recruteurs',
                        'Insertion professionnelle à l\'international facilitée',
                        'Ouverture culturelle et linguistique',
                    ]],
                ],
            ],
            'mobilite' => [
                'slug' => 'mobilite', 'icon' => 'plane', 'color' => '#0d9488', 'badge' => 'Erasmus+',
                'title' => 'Mobilité Internationale', 'subtitle' => 'Étudier & échanger à l\'étranger',
                'description' => "Via le programme Erasmus+ et les conventions internationales, les étudiants effectuent des semestres d'échange, des stages et des séjours de recherche chez les universités partenaires.",
                'points' => ['Programme Erasmus+', 'Semestres d\'échange', 'Stages internationaux', 'Séjours de recherche'],
                'intro' => "Grâce au programme Erasmus+ et à ses nombreuses conventions internationales, l'ENSA Kénitra offre à ses étudiants la possibilité d'effectuer une partie de leur parcours à l'étranger : semestres d'échange, stages, projets de fin d'études et séjours de recherche.",
                'sections' => [
                    ['title' => 'Types de mobilité', 'items' => [
                        'Semestre d\'échange académique',
                        'Stage en entreprise à l\'international',
                        'Projet de fin d\'études (PFE) à l\'étranger',
                        'Séjour de recherche pour doctorants',
                    ]],
                    ['title' => 'Programmes & dispositifs', 'items' => [
                        'Programme Erasmus+ (Union européenne)',
                        'Conventions inter-établissements',
                        'Accords de cotutelle de thèse',
                    ]],
                    ['title' => 'Principales destinations', 'items' => [
                        'France (Polytech, INSA, ESIX, EILCO…)',
                        'Allemagne (Ostfalia)', 'Brésil (UFMS)', 'Pologne (Lublin University of Technology)',
                    ]],
                ],
            ],
        ];
    }

    /**
     * Écoles & universités partenaires (source : ensa.uit.ac.ma/international).
     */
    private function partners(): array
    {
        return [
            'France' => [
                'flag' => '🇫🇷', 'code' => 'FR',
                'schools' => [
                    ['name' => 'Polytech Lille',  'sub' => 'École polytechnique universitaire de Lille'],
                    ['name' => 'Polytech Angers', 'sub' => 'École polytechnique universitaire d\'Angers'],
                    ['name' => 'EILCO',           'sub' => 'École d\'Ingénieurs du Littoral-Côte-d\'Opale'],
                    ['name' => 'ENSIBS',          'sub' => 'ENS d\'Ingénieurs de Bretagne-Sud'],
                    ['name' => 'IMT Alès',        'sub' => 'École Nationale Supérieure des Mines d\'Alès'],
                    ['name' => 'INSA CVL',        'sub' => 'INSA Centre Val de Loire'],
                    ['name' => 'INSA Rennes',     'sub' => 'INSA de Rennes'],
                    ['name' => 'ESIX Normandie',  'sub' => 'École Sup. d\'Ingénieurs – Université de Caen'],
                    ['name' => 'UBO',             'sub' => 'Université de Bretagne-Occidentale'],
                ],
            ],
            'Allemagne' => [
                'flag' => '🇩🇪', 'code' => 'DE',
                'schools' => [
                    ['name' => 'Ostfalia', 'sub' => 'Ostfalia University of Applied Sciences'],
                ],
            ],
            'Brésil' => [
                'flag' => '🇧🇷', 'code' => 'BR',
                'schools' => [
                    ['name' => 'FACOM-UFMS', 'sub' => 'Federal University of Mato Grosso do Sul'],
                ],
            ],
        ];
    }
}
