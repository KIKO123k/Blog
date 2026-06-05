<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure the main admin user exists for ENSA majors
        $admin = User::firstOrCreate(
            ['email' => 'admin.ensa@uit.ac.ma'],
            [
                'name' => 'Administration ENSA Kénitra',
                'password' => Hash::make('adminpassword'),
                'email_verified_at' => now(),
            ]
        );

        // Ensure the regular user exists as before
        $user = User::firstOrCreate(
            ['email' => 'khadijanafia133@gmail.com'],
            [
                'name' => 'Khadija Nafia',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );


        // 1b. Seed 20 other random users
        User::factory(20)->create();

        // 2. Generate 100 unique real-looking article titles in French
        $prefixes = [
            "Comprendre", "Le guide ultime de", "Optimiser", "Introduction à", 
            "Les secrets de", "Les nouveautés de", "Pourquoi utiliser", "Comment maîtriser", 
            "Tout savoir sur", "Débuter avec", "Les meilleures pratiques pour"
        ];
        
        $subjects = [
            "Laravel 12", "l'architecture MVC", "Tailwind CSS", "l'accessibilité web", 
            "la sécurité des API", "Docker et les conteneurs", "la méthode Pomodoro", 
            "la productivité en télétravail", "les bases de données", "TypeScript et Node.js", 
            "React et le State Management", "l'intégration continue (CI/CD)", "le design d'interface (UI/UX)"
        ];
        
        $suffixes = [
            "en 2026", "pour les développeurs", "pour les débutants", "de manière efficace", 
            "dans vos projets", "sans effort", "étape par étape", "comme un pro", 
            "sur le web", "pour le futur"
        ];

        $generatedTitles = [];
        while (count($generatedTitles) < 100) {
            $prefix = $prefixes[array_rand($prefixes)];
            $subject = $subjects[array_rand($subjects)];
            $suffix = $suffixes[array_rand($suffixes)];
            
            $title = "{$prefix} {$subject} {$suffix}";
            $title = ucfirst($title);
            
            if (!in_array($title, $generatedTitles)) {
                $generatedTitles[] = $title;
            }
        }

        // 3. Map subjects to realistic introductory paragraphs
        $intros = [
            "Laravel 12" => "Laravel 12 est la dernière version du framework PHP le plus populaire au monde. Dans cet article, nous allons explorer en détail les nouvelles fonctionnalités, les améliorations de performance et comment mettre à jour vos applications existantes.",
            "l'architecture MVC" => "L'architecture Model-View-Controller (MVC) est un modèle de conception logiciel largement utilisé pour développer des interfaces utilisateur. Découvrez comment structurer votre code de manière propre, testable et maintenable.",
            "Tailwind CSS" => "Tailwind CSS a révolutionné la façon dont nous concevons les interfaces web. Avec son approche utility-first, il permet de créer des designs modernes et responsives extrêmement rapidement et sans quitter vos fichiers HTML.",
            "l'accessibilité web" => "L'accessibilité web (a11y) garantit que les sites internet sont utilisables par tout le monde, y compris les personnes en situation de handicap. Cet article vous montre comment intégrer les standards du W3C dès le début.",
            "la sécurité des API" => "Sécuriser une API REST est une priorité absolue pour protéger les données de vos utilisateurs. Nous passons en revue les meilleures pratiques, de l'authentification OAuth2 aux en-têtes CORS en passant par le rate limiting.",
            "Docker et les conteneurs" => "Docker permet de standardiser l'environnement de développement et de production de vos applications. Apprent à créer vos propres conteneurs et à orchestrer vos services comme un professionnel.",
            "la méthode Pomodoro" => "La méthode Pomodoro est une technique de gestion du temps simple et redoutable pour lutter contre la procrastination. Découvrez comment l'appliquer au quotidien pour doubler votre concentration.",
            "la productivité en télétravail" => "Travailler depuis chez soi présente de nombreux défis en matière d'organisation. Nous avons rassemblé les meilleures astuces pour maintenir un équilibre sain entre vie professionnelle et personnelle.",
            "les bases de données" => "Les bases de données sont le cœur de toute application web moderne. Apprenez à concevoir des schémas optimisés, à écrire des requêtes performantes et à utiliser l'indexation de manière intelligente.",
            "TypeScript et Node.js" => "TypeScript apporte la sécurité du typage statique au monde dynamique de JavaScript. Découvrez comment configurer un environnement de développement moderne avec Node.js et TypeScript.",
            "React et le State Management" => "La gestion de l'état dans les applications React peut rapidement devenir complexe. Cet article explore les différentes solutions disponibles, de l'API Context aux outils comme Redux Toolkit.",
            "l'intégration continue (CI/CD)" => "Automatiser le build, les tests et le déploiement de vos applications permet de gagner un temps précieux et de réduire les erreurs. Voici comment mettre en place un pipeline CI/CD moderne.",
            "le design d'interface (UI/UX)" => "L'interface utilisateur (UI) et l'expérience utilisateur (UX) font la différence entre un produit moyen et un produit exceptionnel. Découvrez les grands principes du design web moderne."
        ];

        // 4. Curated high-quality, beautiful images based on subjects
        $techImages = [
            "https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop",
        ];
        
        $designImages = [
            "https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=800&auto=format&fit=crop",
        ];
        
        $productivityImages = [
            "https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1488998469330-e6aa06a400cf?w=800&auto=format&fit=crop",
        ];
        
        $databaseImages = [
            "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&auto=format&fit=crop",
        ];
        
        $learningImages = [
            "https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop",
        ];

        $getImageForTitle = function($title) use ($techImages, $designImages, $productivityImages, $databaseImages, $learningImages) {
            $t = strtolower($title);
            if (str_contains($t, 'laravel') || str_contains($t, 'api') || str_contains($t, 'docker') || str_contains($t, 'typescript') || str_contains($t, 'react') || str_contains($t, 'ci/cd')) {
                return $techImages[array_rand($techImages)];
            }
            if (str_contains($t, 'design') || str_contains($t, 'ux') || str_contains($t, 'ui') || str_contains($t, 'tailwind')) {
                return $designImages[array_rand($designImages)];
            }
            if (str_contains($t, 'pomodoro') || str_contains($t, 'productivité') || str_contains($t, 'télétravail')) {
                return $productivityImages[array_rand($productivityImages)];
            }
            if (str_contains($t, 'bases de données') || str_contains($t, 'mvc') || str_contains($t, 'sql')) {
                return $databaseImages[array_rand($databaseImages)];
            }
            return $learningImages[array_rand($learningImages)];
        };

        // 5. Create post models with ordered dates from 1/1/2025 to now
        $posts = [];
        $startDate = Carbon::create(2025, 1, 1, 9, 0, 0);
        $endDate = Carbon::now();
        $totalSeconds = $startDate->diffInSeconds($endDate);
        $totalPosts = count($generatedTitles);
        $intervalSeconds = $totalSeconds / max(1, $totalPosts - 1);
        
        foreach ($generatedTitles as $index => $title) {
            $intro = "";
            foreach ($intros as $subj => $text) {
                if (stripos($title, $subj) !== false) {
                    $intro = $text;
                    break;
                }
            }
            
            if (empty($intro)) {
                $intro = "Dans cet article complet, nous allons analyser en profondeur les aspects clés de ce sujet et vous donner des conseils pratiques pour vos projets quotidiens.";
            }
            
            $paragraphs = fake('fr_FR')->paragraphs(rand(3, 5));
            $bodyContent = $intro . "\n\n" . implode("\n\n", $paragraphs);
            
            $createdAt = $startDate->copy()->addSeconds(round($index * $intervalSeconds));
            
            $posts[] = [
                'user_id' => $user->id,
                'title' => $title,
                'content' => $bodyContent,
                'image' => $getImageForTitle($title),
                'views' => rand(0, 1000),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        // 6. Bulk insert articles
        // Insert regular posts in chunks
        foreach (array_chunk($posts, 25) as $chunk) {
            Post::insert($chunk);
        }

        // --- Seed detailed majors as full articles (idempotent) ---
        $majors = [
            [
                'title' => 'Réseaux et Systèmes de Télécommunications',
                'content' => "<h2>Présentation</h2><p>Cette filière forme des ingénieurs spécialisés dans les réseaux informatiques, les télécommunications, la cybersécurité et les infrastructures numériques modernes.</p>"
                    . "<h3>Compétences développées</h3><ul><li>Conception d'architectures réseaux</li><li>Gestion de la sécurité des communications</li><li>Déploiement d'infrastructures 5G</li></ul>"
                    . "<h3>Matières principales</h3><ul><li>Protocoles TCP/IP</li><li>Systèmes sans fil</li><li>Cybersécurité avancée</li></ul>"
                    . "<h3>Technologies utilisées</h3><ul><li>Wi‑Fi 6, 5G, LTE</li><li>Outils de simulation réseau (NS‑3, GNS3)</li><li>Protocoles de sécurité (IPSec, TLS)</li></ul>"
                    . "<h3>Débouchés professionnels</h3><p>Ingénieur réseau, architecte télécom, consultant en cybersécurité, chef de projet infrastructure.</p>"
                    . "<h3>Marché de l'emploi</h3><p>La demande d'experts en télécom et cybersécurité est en forte croissance, notamment avec l'expansion des réseaux 5G et l'essor du cloud.</p>"
                    . "<h3>Conseils aux étudiants</h3><p>Pratiquer les labs de configuration, obtenir des certifications (Cisco CCNA, CompTIA Security+), et participer à des projets open‑source.</p>",
                'image' => 'https://images.unsplash.com/photo-1517242021261-c4c49e2f5d57?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Génie Informatique',
                'content' => "<h2>Présentation</h2><p>Formation d'ingénieurs experts en développement logiciel, architectures systèmes et technologies émergentes.</p>"
                    . "<h3>Compétences développées</h3><ul><li>Programmation avancée (C++, Java, Python)</li><li>Architecture logicielle</li><li>DevOps et CI/CD</li></ul>"
                    . "<h3>Matières principales</h3><ul><li>Algorithmique</li><li>Base de données</li><li>Intelligence artificielle</li></ul>"
                    . "<h3>Technologies utilisées</h3><ul><li>Frameworks web (Laravel, React)</li><li>Conteneurs Docker</li><li>Cloud (AWS, Azure)</li></ul>"
                    . "<h3>Débouchés professionnels</h3><p>Développeur senior, architecte logiciel, chef de projet IT, consultant en transformation digitale.</p>"
                    . "<h3>Marché de l'emploi</h3><p>Le secteur du logiciel continue de croître rapidement, avec une forte demande pour les spécialistes du cloud et de la cybersécurité.</p>"
                    . "<h3>Conseils aux étudiants</h3><p>Contribuer à des projets open‑source, obtenir des certifications cloud, et réaliser des stages en entreprise.</p>",
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Génie Industriel',
                'content' => "<h2>Présentation</h2><p>Cette filière prépare les ingénieurs à optimiser les processus de production, la logistique et la qualité industrielle.</p><h3>Compétences développées</h3><ul><li>Analyse des flux de production</li><li>Gestion de la chaîne d'approvisionnement</li><li>Automatisation et robotique</li></ul><h3>Matières principales</h3><ul><li>Gestion de projet industriel</li><li>Qualité et amélioration continue</li><li>Simulation de processus</li></ul><h3>Débouchés professionnels</h3><p>Ingénieur production, consultant Lean, responsable supply chain, chef de projet automatisation.</p>",
                'image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Génie Électrique',
                'content' => "<h2>Présentation</h2><p>Formation centrée sur les systèmes électriques, l'électronique de puissance et les énergies renouvelables.</p><h3>Compétences développées</h3><ul><li>Conception de circuits</li><li>Gestion d'énergie</li><li>Électronique embarquée</li></ul><h3>Matières principales</h3><ul><li>Électrotechnique</li><li>Automates programmables</li><li>Énergies vertes</li></ul><h3>Débouchés professionnels</h3><p>Ingénieur électricien, concepteur de systèmes embarqués, consultant en énergie durable.</p>",
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Génie Mécatronique',
                'content' => "<h2>Présentation</h2><p>Ce cursus associe mécanique, électronique et informatique pour créer des systèmes automatisés intelligents.</p><h3>Compétences développées</h3><ul><li>Conception robotique</li><li>Contrôle de systèmes</li><li>Programmation temps réel</li></ul><h3>Matières principales</h3><ul><li>Robotique</li><li>Automatique</li><li>Instrumentation</li></ul><h3>Débouchés professionnels</h3><p>Ingénieur robotique, concepteur de systèmes automatisés, développeur d'IoT industriel.</p>",
                'image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Génie Énergétique et Énergies Renouvelables',
                'content' => "<h2>Présentation</h2><p>Programme dédié à la conception de solutions énergétiques durables, l'optimisation de l'efficacité énergétique et la gestion des ressources renouvelables.</p><h3>Compétences développées</h3><ul><li>Analyse énergétique</li><li>Conception de systèmes solaires et éoliens</li><li>Gestion de projets d’efficacité énergétique</li></ul><h3>Matières principales</h3><ul><li>Thermodynamique</li><li>Énergies renouvelables</li><li>Gestion de la demande énergétique</li></ul><h3>Débouchés professionnels</h3><p>Consultant en énergie, ingénieur projet renouvelable, auditeur énergétique, responsable RSE.</p>",
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop',
            ],
        ];

                foreach ($majors as $major) {
            // Check if an article with this title already exists
            $exists = \App\Models\Post::where('title', $major['title'])->exists();
            if (! $exists) {
                \App\Models\Post::create([
                    'user_id' => $admin->id,
                    'title' => $major['title'],
                    'content' => $major['content'],
                    'image' => $major['image'],
                    'views' => rand(0, 1000),
                    'created_at' => now()->subDays(rand(0, 365)),
                    'updated_at' => now(),
                ]);
            }
        }


        // 7. Seed comments for each post
        $allPosts = Post::all();
        $comments = [];
        
        $commentTexts = [
            "Super article, merci beaucoup pour ces explications très claires !",
            "Je me demandais s'il y avait des limitations avec cette approche sur de gros projets ?",
            "Excellent guide, très bien structuré et facile à suivre.",
            "Une petite question : comment gérez-vous ce cas particulier en production ?",
            "Je cherchais justement une documentation simple sur ce sujet, merci !",
            "Très intéressant ! J'ai hâte de lire votre prochain article.",
            "Est-ce compatible avec les versions précédentes ?",
            "Merci pour le partage, les exemples de code m'ont beaucoup aidé.",
            "C'est exactement ce dont j'avais besoin pour mon projet universitaire.",
            "Un grand merci pour ce tutoriel détaillé !",
            "Article très complet et agréable à lire. Félicitations !"
        ];
        
        foreach ($allPosts as $post) {
            $numberOfComments = rand(1, 4);
            for ($i = 0; $i < $numberOfComments; $i++) {
                // Generate a comment date after the post date, but before now
                $postDate = Carbon::parse($post->created_at);
                $commentDate = $postDate->copy()->addMinutes(rand(10, 1440 * 5)); // 10 minutes to 5 days later
                if ($commentDate->gt(Carbon::now())) {
                    $commentDate = Carbon::now();
                }
                
                $comments[] = [
                    'post_id' => $post->id,
                    'author_name' => fake('fr_FR')->name(),
                    'content' => $commentTexts[array_rand($commentTexts)],
                    'created_at' => $commentDate,
                    'updated_at' => $commentDate,
                ];
            }
        }
        
        // Insert comments in chunks of 50
        foreach (array_chunk($comments, 50) as $chunk) {
            Comment::insert($chunk);
        }
    }
}
