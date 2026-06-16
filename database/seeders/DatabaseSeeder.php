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
        $this->call(CategorySeeder::class);
        $this->call(ClubSeeder::class);       // les clubs doivent exister...
        $this->call(ClubMemberSeeder::class); // ...avant d'attacher leurs membres
        $this->call(EventSeeder::class);      // événements des clubs
        $this->call(EcosystemSeeder::class);  // team posts, lost&found, offres

        // Real users only — no factory dummies
        $users = [];

        $users[] = User::firstOrCreate(
            ['email' => 'admin.ensa@uit.ac.ma'],
            ['name' => 'Administration ENSA Kénitra', 'password' => Hash::make('adminpassword'), 'email_verified_at' => now(), 'is_admin' => true]
        );
        // Ensure the admin flag is set even if the user already existed
        $users[0]->forceFill(['is_admin' => true, 'role' => 'admin'])->save();
        $users[] = User::firstOrCreate(
            ['email' => 'khadijanafia133@gmail.com'],
            ['name' => 'Khadija Nafia', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $users[] = User::firstOrCreate(
            ['email' => 'yassine.benali@ensa.ma'],
            ['name' => 'Yassine Benali', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $users[] = User::firstOrCreate(
            ['email' => 'sara.elhassan@ensa.ma'],
            ['name' => 'Sara El Hassan', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $users[] = User::firstOrCreate(
            ['email' => 'omar.tazi@ensa.ma'],
            ['name' => 'Omar Tazi', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );

        $admin = $users[0];
        $user  = $users[1];

        // 2. Curated articles for engineering students — skills & competences
        $curatedArticles = [
            // ── PROGRAMMATION ──────────────────────────────────────────
            [
                'title' => 'Maîtriser Git et GitHub : guide complet pour ingénieurs',
                'content' => "Git est l'outil de versioning incontournable pour tout développeur ou ingénieur logiciel. Que vous travailliez seul ou en équipe, comprendre Git en profondeur est une compétence fondamentale.\n\nDans ce guide nous couvrons les commandes essentielles : git init, clone, add, commit, push, pull, et merge. Nous explorons ensuite les workflows avancés comme Git Flow, les rebases interactifs et la résolution de conflits.\n\nNous abordons également GitHub en tant que plateforme collaborative : création de Pull Requests, code review, gestion des Issues, Actions CI/CD et protection des branches. À la fin de ce guide vous serez en mesure de gérer n'importe quel projet de code de manière professionnelle.",
                'image' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Python pour ingénieurs : de zéro à l\'analyse de données',
                'content' => "Python est devenu le langage de référence pour les ingénieurs, que ce soit en traitement du signal, en automatisation, en intelligence artificielle ou en simulation numérique.\n\nCe guide pratique commence par les bases du langage (types, fonctions, modules) puis monte progressivement vers les bibliothèques indispensables : NumPy pour le calcul matriciel, Pandas pour la manipulation de données, Matplotlib et Seaborn pour la visualisation, et SciPy pour les calculs scientifiques.\n\nNous terminons par un projet complet : analyse statistique d'un jeu de données industriel avec nettoyage, visualisation et rapport automatique. Idéal pour les étudiants en GI, GE ou RST.",
                'image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Algorithmes et structures de données : les bases que tout ingénieur doit connaître',
                'content' => "Les algorithmes et structures de données sont le fondement de l'informatique. Une bonne maîtrise de ces concepts vous distingue dans les entretiens techniques et dans la résolution de problèmes réels.\n\nNous couvrons les structures classiques : tableaux, listes chaînées, piles, files, arbres binaires et graphes. Ensuite nous analysons les algorithmes de tri (quicksort, mergesort), de recherche (BFS, DFS, Dijkstra) et les paradigmes de résolution comme la programmation dynamique et le diviser pour régner.\n\nChaque concept est accompagné d'une implémentation en Python avec analyse de la complexité temporelle (notation O). Ce cours vous prépare aux tests techniques des grandes entreprises marocaines et internationales.",
                'image' => 'https://images.unsplash.com/photo-1509228627152-72ae9ae6848d?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'C++ moderne pour systèmes embarqués : pointeurs, mémoire et RAII',
                'content' => "Le C++ reste le langage dominant dans les systèmes embarqués, l'automobile, la robotique et les applications temps réel. Comprendre ses mécanismes avancés est essentiel pour les ingénieurs en mécatronique, électrique et informatique.\n\nCe guide couvre la gestion manuelle de la mémoire (new/delete, stack vs heap), les pointeurs intelligents (unique_ptr, shared_ptr), les références et le pattern RAII pour éviter les fuites mémoire. Nous abordons aussi les templates, la programmation orientée objet et les fonctionnalités du C++17 utiles pour l'embarqué.\n\nDes exemples concrets sur Arduino et STM32 illustrent chaque concept. À la fin vous saurez écrire du code C++ performant, sûr et maintenable pour des contraintes temps réel.",
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Introduction à Docker : conteneuriser vos applications en 1 heure',
                'content' => "Docker révolutionne le déploiement d'applications en garantissant que votre code fonctionne de la même manière sur tous les environnements. C'est devenu une compétence quasi obligatoire pour les ingénieurs DevOps et les développeurs backend.\n\nNous commençons par comprendre les concepts fondamentaux : images, conteneurs, Dockerfile et Docker Compose. Ensuite nous créons pas à pas un environnement de développement complet avec une application web, une base de données et un serveur de cache, le tout orchestré avec Docker Compose.\n\nNous abordons également les bonnes pratiques : images légères avec multi-stage builds, gestion des secrets, networking entre conteneurs et stratégies de déploiement en production. Un atelier pratique conclut le guide.",
                'image' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Linux pour ingénieurs : commandes essentielles et scripting Bash',
                'content' => "Linux est l'OS de référence dans les serveurs, les systèmes embarqués et les environnements cloud. Tout ingénieur devrait maîtriser les bases de la ligne de commande pour être efficace dans son travail quotidien.\n\nNous couvrons les commandes fondamentales de navigation et de gestion de fichiers, les permissions et la gestion des utilisateurs, les processus et signaux, et la configuration réseau. La deuxième partie est consacrée au scripting Bash : boucles, conditions, fonctions, expressions régulières et automatisation de tâches répétitives.\n\nEnfin nous explorons des sujets avancés comme cron jobs, systemd, SSH et la gestion de paquets. Avec ces compétences vous serez à l'aise dans n'importe quel environnement professionnel.",
                'image' => 'https://images.unsplash.com/photo-1629654297299-c8506221ca97?w=800&auto=format&fit=crop',
            ],

            // ── MATHÉMATIQUES & SCIENCES ────────────────────────────────
            [
                'title' => 'Algèbre linéaire appliquée : de la théorie au Machine Learning',
                'content' => "L'algèbre linéaire est la langue mathématique du Machine Learning, de la robotique et du traitement du signal. Pourtant beaucoup d'étudiants peinent à faire le lien entre les cours théoriques et les applications concrètes.\n\nCe guide fait le pont entre les deux : nous partons des vecteurs et matrices, couvrons les opérations fondamentales, les espaces vectoriels, les valeurs propres et la décomposition SVD. Puis nous montrons comment ces concepts alimentent directement la régression linéaire, les réseaux de neurones et la compression d'images.\n\nTous les exemples sont implémentés avec NumPy en Python. Ce guide est particulièrement utile pour les étudiants en GI qui préparent leurs cours d'IA ou de traitement d'images.",
                'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Probabilités et statistiques pour ingénieurs : du théorème de Bayes aux tests d\'hypothèse',
                'content' => "Les probabilités et statistiques sont indispensables pour analyser des données expérimentales, concevoir des capteurs fiables ou évaluer des performances de systèmes. Ce guide s'adresse aux étudiants ingénieurs qui veulent consolider ces bases.\n\nNous couvrons les distributions de probabilité (normale, Poisson, exponentielle), les estimateurs statistiques, les intervalles de confiance et les tests d'hypothèse (t-test, chi-carré). Une partie entière est dédiée au théorème de Bayes et ses applications en diagnostic de systèmes et en filtrage de Kalman.\n\nDes exercices pratiques avec Python (scipy.stats) permettent de mettre en œuvre chaque concept sur des données réelles. Idéal pour les cours de fiabilité et de qualité en Génie Industriel.",
                'image' => 'https://images.unsplash.com/photo-1518186285589-2f7649de83e0?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Méthodes numériques : résolution d\'équations différentielles avec MATLAB',
                'content' => "Les méthodes numériques permettent de résoudre des problèmes mathématiques complexes que les méthodes analytiques ne peuvent pas traiter. MATLAB est l'outil standard dans les domaines de l'ingénierie pour ces calculs.\n\nCe guide couvre la résolution d'équations non-linéaires (méthode de Newton-Raphson), l'intégration numérique (Simpson, Runge-Kutta), la résolution de systèmes d'équations différentielles ordinaires et aux dérivées partielles.\n\nChaque méthode est implémentée pas à pas en MATLAB avec visualisation des résultats. Nous illustrons les applications en mécanique des fluides, thermique et dynamique des systèmes. Un projet final modélise un système masse-ressort-amortisseur.",
                'image' => 'https://images.unsplash.com/photo-1509228468518-180dd4864904?w=800&auto=format&fit=crop',
            ],

            // ── INTELLIGENCE ARTIFICIELLE ───────────────────────────────
            [
                'title' => 'Introduction au Machine Learning : comprendre les algorithmes fondamentaux',
                'content' => "Le Machine Learning transforme tous les secteurs industriels. Comprendre ses fondements vous permettra d'identifier les cas d'usage pertinents dans votre domaine d'ingénierie et de collaborer efficacement avec les data scientists.\n\nNous commençons par les concepts clés : apprentissage supervisé vs non-supervisé, underfitting/overfitting, validation croisée. Ensuite nous détaillons les algorithmes essentiels : régression linéaire et logistique, arbres de décision, Random Forest, SVM et k-means.\n\nChaque algorithme est expliqué intuitivement puis implémenté avec scikit-learn. Nous terminons par un projet complet de classification sur un dataset industriel : prétraitement, sélection de modèle, évaluation et interprétation des résultats.",
                'image' => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Réseaux de neurones et Deep Learning : de la théorie à TensorFlow',
                'content' => "Les réseaux de neurones profonds sont au cœur de la révolution IA. Ce guide démystifie leur fonctionnement et vous donne les bases pour construire vos premiers modèles avec TensorFlow et Keras.\n\nNous partons du perceptron simple, comprenons la rétropropagation et la descente de gradient, puis construisons des réseaux denses (MLP). Nous progressons vers les architectures spécialisées : CNN pour la vision par ordinateur, RNN et LSTM pour les séries temporelles, et les Transformers pour le NLP.\n\nUn projet de classification d'images (détection de défauts industriels) guide vous à travers les étapes : préparation des données, architecture du modèle, entraînement, évaluation et déploiement. Applications directes en contrôle qualité et maintenance prédictive.",
                'image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'IoT et systèmes intelligents : connecter des capteurs au cloud',
                'content' => "L'Internet des Objets connecte le monde physique au numérique. Pour les ingénieurs en mécatronique, électrique et industriel, comprendre l'architecture IoT est une compétence de plus en plus demandée.\n\nNous explorons l'architecture IoT de bout en bout : capteurs et actionneurs (température, pression, vibration), microcontrôleurs (ESP32, STM32), protocoles de communication (MQTT, CoAP, HTTP), gateways et plateformes cloud (AWS IoT, Azure IoT Hub).\n\nUn projet pratique guide le déploiement d'un système de surveillance en temps réel : acquisition de données sur ESP32, transmission MQTT, stockage sur InfluxDB, visualisation sur Grafana. Code complet fourni avec explications. Applications en maintenance prédictive et smart manufacturing.",
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&auto=format&fit=crop',
            ],

            // ── RÉSEAUX & CYBERSÉCURITÉ ────────────────────────────────
            [
                'title' => 'Cybersécurité pour ingénieurs : les 10 vulnérabilités à connaître absolument',
                'content' => "La cybersécurité n'est plus réservée aux spécialistes IT. Tout ingénieur qui développe des logiciels, configure des réseaux ou déploie des systèmes embarqués doit connaître les vulnérabilités fondamentales pour les éviter.\n\nNous couvrons l'OWASP Top 10 : injection SQL, XSS, CSRF, mauvaise configuration, exposition de données sensibles, contrôle d'accès défaillant et plus encore. Chaque vulnérabilité est illustrée par un exemple d'attaque réel et une contre-mesure concrète.\n\nLa deuxième partie aborde la sécurité des systèmes embarqués et IoT : protection du firmware, chiffrement des communications, authentification des dispositifs et bonnes pratiques pour le développement sécurisé. Un incontournable pour les étudiants en RST et GI.",
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Réseaux TCP/IP : comment fonctionne vraiment Internet',
                'content' => "Comprendre le modèle TCP/IP en profondeur est fondamental pour tout ingénieur réseau, développeur backend ou architecte système. Ce guide va au-delà du cours magistral et explique le fonctionnement réel du réseau.\n\nNous disséquons chaque couche du modèle : physique (Ethernet, Wi-Fi), réseau (IP, ICMP, ARP, routage), transport (TCP avec handshake et contrôle de congestion, UDP) et application (HTTP/2, TLS, DNS). Chaque concept est illustré par des captures Wireshark commentées.\n\nLa partie pratique couvre la configuration d'un réseau avec VLANs, NAT, pare-feu et routage statique/dynamique (OSPF). Les exercices sur GNS3 vous permettent de simuler des topologies réseau complètes. Préparation idéale à la certification Cisco CCNA.",
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&auto=format&fit=crop',
            ],

            // ── GÉNIE INDUSTRIEL & LEAN ─────────────────────────────────
            [
                'title' => 'Lean Manufacturing : éliminer les gaspillages et optimiser les flux de production',
                'content' => "Le Lean Manufacturing est la philosophie de gestion de production qui a transformé Toyota et l'industrie mondiale. Comprendre et appliquer ses principes est une compétence clé pour les ingénieurs en génie industriel.\n\nNous couvrons les 7 types de gaspillages (Muda), le Value Stream Mapping pour analyser et optimiser les flux, les 5S pour l'organisation du poste de travail, le Kanban pour la gestion de la production en flux tiré, et le SMED pour réduire les temps de changement de série.\n\nChaque outil est illustré par un cas d'application industriel concret avec des chiffres réels d'amélioration. Nous terminons par la démarche Kaizen et comment animer un chantier d'amélioration continue en entreprise. Essentiel pour les stages en usine.",
                'image' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Gestion de projet avec la méthode Agile Scrum : guide pratique',
                'content' => "Agile Scrum est devenu le standard de la gestion de projet dans les entreprises technologiques. Que vous développiez un logiciel, un produit industriel ou un système IoT, maîtriser Scrum vous rendra plus efficace en équipe.\n\nNous expliquons le cadre Scrum complet : rôles (Product Owner, Scrum Master, équipe de développement), cérémonies (sprint planning, daily standup, sprint review, rétrospective) et artefacts (Product Backlog, Sprint Backlog, Increment).\n\nNous comparons Scrum avec Kanban et les méthodes classiques (cycle en V, waterfall) pour vous aider à choisir la bonne approche selon le contexte. Des outils comme Jira et Trello sont présentés avec des exemples de configuration pour un projet réel. Indispensable pour les projets de fin d'études.",
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Six Sigma et contrôle qualité : méthode DMAIC pour les ingénieurs',
                'content' => "Six Sigma est une méthodologie structurée pour réduire les défauts et améliorer la qualité des processus industriels. La certification Green Belt ou Black Belt est très valorisée dans l'industrie marocaine et internationale.\n\nNous détaillons la démarche DMAIC : Définir les problèmes et les objectifs, Mesurer les performances actuelles, Analyser les causes racines (diagramme Ishikawa, Pareto), Innover en proposant des solutions, Contrôler pour pérenniser les améliorations.\n\nNous introduisons les outils statistiques associés : cartes de contrôle SPC, capabilité de processus (Cp, Cpk), analyse des systèmes de mesure (MSA) et plans d'expériences (DOE). Avec des exemples chiffrés tirés de l'industrie automobile et électronique.",
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&auto=format&fit=crop',
            ],

            // ── ÉNERGIE & ÉLECTRIQUE ────────────────────────────────────
            [
                'title' => 'Énergies renouvelables : dimensionner une installation solaire photovoltaïque',
                'content' => "Le solaire photovoltaïque est l'une des filières énergétiques à plus forte croissance au Maroc, avec des objectifs nationaux ambitieux à horizon 2030. Savoir dimensionner une installation est une compétence directement monnayable.\n\nCe guide couvre le principe de fonctionnement des cellules PV, les caractéristiques électriques des panneaux (courbe I-V, puissance crête), le dimensionnement du générateur solaire selon la charge et l'ensoleillement, le choix et le dimensionnement des batteries, onduleurs et régulateurs de charge.\n\nNous effectuons un dimensionnement complet pas à pas : villa résidentielle, site isolé et raccordement réseau. Les calculs sont réalisés avec des outils comme PVsyst et des feuilles Excel commentées. Idéal pour le projet de fin d'études en GE ou GEer.",
                'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Électronique embarquée : programmer un STM32 avec HAL et FreeRTOS',
                'content' => "Les microcontrôleurs STM32 de STMicroelectronics sont omniprésents dans l'industrie : automobile, médical, robotique, domotique. Savoir les programmer efficacement est une compétence très demandée en mécatronique et génie électrique.\n\nNous partons de zéro : configuration de l'environnement STM32CubeIDE, génération de code avec CubeMX, comprendre la couche HAL. Nous progressons vers les périphériques essentiels : GPIO, UART, SPI, I2C, ADC/DAC, PWM et timers.\n\nLa deuxième partie introduit FreeRTOS : tâches, files de messages, sémaphores et mutex pour gérer la concurrence dans les systèmes embarqués temps réel. Un projet complet guide le contrôle d'un moteur DC avec mesure de position via encodeur et affichage OLED.",
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&auto=format&fit=crop',
            ],

            // ── COMPÉTENCES TRANSVERSES ─────────────────────────────────
            [
                'title' => 'Comment rédiger un rapport technique et un mémoire de fin d\'études qui impressionne',
                'content' => "Le mémoire de fin d'études est souvent la production écrite la plus importante de votre cursus. Sa qualité peut faire la différence lors de la soutenance et dans l'impression que vous laissez aux professionnels qui le liront.\n\nCe guide couvre la structure d'un bon rapport d'ingénieur : de la problématique à la conclusion en passant par l'état de l'art, la méthodologie et les résultats. Nous détaillons les règles de typographie et de mise en page, la rédaction de figures et tableaux clairs, la gestion des références bibliographiques avec Zotero.\n\nNous abordons aussi la rédaction en anglais technique pour les publications et la présentation orale devant jury : structure d'un exposé de 20 minutes, gestion du stress, réponse aux questions du jury. Conseils tirés d'expériences de jurys ENSA.",
                'image' => 'https://images.unsplash.com/photo-1456324504439-367cee3b3c32?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Trouver et réussir son stage en entreprise : conseils pour étudiants ingénieurs',
                'content' => "Le stage est une étape cruciale dans le parcours d'un ingénieur. Il peut déboucher sur une offre d'emploi et constitue une ligne déterminante de votre CV. Pourtant beaucoup d'étudiants ne savent pas comment s'y prendre.\n\nNous couvrons toutes les étapes : cibler les entreprises selon votre filière et vos ambitions, rédiger un CV et une lettre de motivation qui sortent du lot, préparer l'entretien de recrutement avec des questions types et des exercices pratiques.\n\nPendant le stage : comment s'intégrer, fixer des objectifs clairs avec votre maître de stage, documenter votre travail dès le premier jour et gérer les imprévus. Après : négocier une prolongation ou un CDI, transformer l'expérience en compétences valorisables sur LinkedIn. Avec des exemples réels d'étudiants ENSA.",
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Optimiser sa présence LinkedIn : le guide de l\'ingénieur qui veut être recruté',
                'content' => "LinkedIn est devenu le premier canal de recrutement des cadres et ingénieurs au Maroc. Un profil bien construit peut vous valoir des sollicitations de recruteurs même sans chercher activement un emploi.\n\nNous guidons l'optimisation de chaque section : photo professionnelle, titre accrocheur, résumé qui raconte votre histoire, expériences avec des verbes d'action et des métriques concrètes, compétences validées par des pairs. Nous expliquons l'algorithme LinkedIn et comment augmenter votre visibilité organique.\n\nStratégies avancées : rejoindre les bons groupes, publier du contenu technique régulièrement, utiliser LinkedIn Learning pour les certifications affichées, et contacter des recruteurs de manière efficace. Des templates de messages et un calendrier éditorial sont fournis.",
                'image' => 'https://images.unsplash.com/photo-1611944212129-29977ae1398c?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Introduction à la recherche scientifique : lire, comprendre et citer des articles académiques',
                'content' => "Savoir naviguer dans la littérature scientifique est une compétence essentielle pour les projets de fin d'études, les masters et la recherche. Pourtant elle est rarement enseignée explicitement dans les cursus d'ingénierie.\n\nNous couvrons la structure d'un article scientifique (abstract, introduction, méthodes, résultats, discussion) et comment le lire efficacement en 20 minutes. Nous présentons les bases de données de recherche : Google Scholar, IEEE Xplore, ScienceDirect, ResearchGate et arXiv.\n\nNous abordons les métriques d'impact (facteur h, citations), la gestion des références avec Zotero et Mendeley, comment éviter le plagiat et les règles de citation (IEEE, APA). Enfin nous expliquons comment évaluer la crédibilité d'une source et éviter les revues prédatrices.",
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Méthode de travail pour ingénieurs : comment réviser efficacement et réussir ses examens',
                'content' => "Les études d'ingénierie sont exigeantes et la charge de travail est intense. Avoir une méthode de travail efficace peut faire une différence énorme sur vos résultats sans nécessairement travailler plus longtemps.\n\nNous présentons les techniques de mémorisation les plus efficaces validées par la recherche en neurosciences : la répétition espacée (Anki), le rappel actif, l'interleaving et l'élaboration. Nous montrons comment organiser ses révisions en période d'examens avec un planning type.\n\nNous abordons aussi la gestion de la charge cognitive : comment décomposer des problèmes complexes, créer des cartes mentales, utiliser des techniques de lecture rapide pour les cours denses. Conseils pratiques adaptés au rythme des semestres ENSA et aux types d'examens (QCM, problèmes, projets).",
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop',
            ],

            // ── GÉNIE CIVIL & MÉCANIQUE ─────────────────────────────────
            [
                'title' => 'Résistance des matériaux : comprendre les contraintes et déformations',
                'content' => "La résistance des matériaux (RDM) est l'une des matières fondamentales de tout cursus d'ingénieur. Elle permet de concevoir des structures sûres et économiques en anticipant leur comportement sous charge.\n\nCe guide couvre les concepts essentiels : contraintes normales et tangentielles, déformations, loi de Hooke, moments fléchissants et efforts tranchants dans les poutres, torsion et flambement. Chaque concept est illustré par des diagrammes clairs et des exercices résolus.\n\nNous montrons comment utiliser des logiciels de calcul par éléments finis (FEA) comme Abaqus et ANSYS pour valider les calculs analytiques. Applications en conception mécanique : dimensionnement d'arbres, de poutres industrielles et de structures soudées. Avec des données de matériaux réels (acier, aluminium, composites).",
                'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Automatique : concevoir et régler un correcteur PID pas à pas',
                'content' => "Le PID (Proportionnel-Intégral-Dérivé) est le correcteur le plus utilisé dans l'industrie. Thermorégulation, contrôle de vitesse de moteurs, asservissement de position : il est partout. Savoir le concevoir et le régler est incontournable en automatique.\n\nNous partons de la modélisation d'un système dynamique avec les fonctions de transfert et les diagrammes de Bode. Nous expliquons intuitivement le rôle de chaque terme du PID, puis présentons les méthodes de réglage : Ziegler-Nichols, méthode de la tangente et réglage par placement de pôles.\n\nLa partie pratique utilise MATLAB/Simulink pour simuler et régler des correcteurs PID sur des systèmes du 1er et 2e ordre. Nous terminons par une implémentation sur Arduino avec un système réel de contrôle de température.",
                'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800&auto=format&fit=crop',
            ],

            // ── DÉVELOPPEMENT WEB & CLOUD ───────────────────────────────
            [
                'title' => 'APIs REST : concevoir et documenter une API robuste avec OpenAPI',
                'content' => "Les APIs REST sont le langage universel des architectures modernes. Que vous développiez un backend web, une application mobile ou un système IoT, savoir concevoir une bonne API est une compétence fondamentale.\n\nNous couvrons les principes REST : ressources, verbes HTTP, codes de statut, HATEOAS et versioning. Nous abordons l'authentification (JWT, OAuth 2.0, API keys), la gestion des erreurs, la pagination et le filtrage. Une partie importante est dédiée aux bonnes pratiques de nommage et de structure.\n\nNous utilisons la spécification OpenAPI 3.0 pour documenter l'API avec Swagger UI. Des exemples concrets en Laravel et Node.js illustrent chaque concept. Nous terminons par les tests automatisés d'API avec Postman et les stratégies de déploiement sécurisé.",
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Cloud Computing : AWS, Azure ou GCP — comment choisir et démarrer',
                'content' => "Le cloud est devenu l'infrastructure par défaut pour déployer des applications modernes. Les compétences cloud sont parmi les plus demandées et les mieux rémunérées dans l'informatique.\n\nNous comparons les trois grands fournisseurs (AWS, Azure, Google Cloud) selon les critères pertinents pour un ingénieur débutant : offre gratuite, documentation, certifications reconnues et présence au Maroc et en Afrique. Nous conseillons AWS pour débuter grâce à son niveau gratuit généreux.\n\nNous guidons les premiers pas : création d'un compte, déploiement d'une application web sur EC2, stockage de fichiers sur S3, gestion d'une base de données RDS et mise en place d'un pipeline CI/CD avec CodePipeline. Préparation à la certification AWS Cloud Practitioner incluse.",
                'image' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&auto=format&fit=crop',
            ],
        ];

        // 5. Create post models with ordered dates from 1/1/2025 to now
        $posts = [];
        $startDate = Carbon::create(2025, 1, 1, 9, 0, 0);
        $endDate = Carbon::now();
        $totalSeconds = $startDate->diffInSeconds($endDate);
        $totalPosts = count($curatedArticles);
        $intervalSeconds = $totalPosts > 1 ? $totalSeconds / ($totalPosts - 1) : 0;

        foreach ($curatedArticles as $index => $article) {
            $createdAt = $startDate->copy()->addSeconds(round($index * $intervalSeconds));
            // Distribute articles round-robin across all real users
            $author = $users[$index % count($users)];
            $posts[] = [
                'user_id' => $author->id,
                'title'   => $article['title'],
                'slug'    => \Illuminate\Support\Str::slug($article['title']),
                'content' => $article['content'],
                'image'   => $article['image'],
                'views'   => rand(50, 1500),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        // 6. Bulk insert articles
        foreach (array_chunk($posts, 25) as $chunk) {
            Post::insert($chunk);
        }

        Post::backfillMissingSlugs();

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
            $slug = \Illuminate\Support\Str::slug($major['title']);
            $exists = \App\Models\Post::where('slug', $slug)->exists();
            if (! $exists) {
                \App\Models\Post::create([
                    'user_id'    => $admin->id,
                    'title'      => $major['title'],
                    'slug'       => $slug,
                    'content'    => $major['content'],
                    'image'      => $major['image'],
                    'views'      => rand(0, 1000),
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
