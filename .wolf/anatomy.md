# anatomy.md

> Auto-maintained by OpenWolf. Last scanned: 2026-06-16T20:51:58.162Z
> Files: 600 tracked | Anatomy hits: 0 | Misses: 0

## ./

- `.editorconfig` — Editor configuration (~68 tok)
- `.gitattributes` — Git attributes (~50 tok)
- `.gitignore` — Git ignore rules (~78 tok)
- `.phpunit.result.cache` (~228 tok)
- `artisan` — Laravel CLI entry point (~114 tok)
- `CLAUDE.md` — OpenWolf (~57 tok)
- `composer.json` — PHP package manifest (~814 tok)
- `package.json` — Node.js package manifest (~119 tok)
- `phpunit.xml` (~378 tok)
- `README.md` — Project documentation (~978 tok)
- `vite.config.js` — Vite build configuration (~125 tok)

## .claude/

- `settings.json` (~441 tok)

## .claude/rules/

- `openwolf.md` (~313 tok)

## app/Http/Controllers/

- `AuthController.php` — Show the registration form. (~1440 tok)
- `ClubController.php` — index, show, store (~322 tok)
- `CommentController.php` — Store a newly created comment in storage. (~378 tok)
- `Controller.php` — Controller: Controller (~21 tok)
- `DashboardController.php` — Tableau de bord personnel de l'étudiant connecté. (~311 tok)
- `EcosystemController.php` — aiSpace, findTeammates, storeTeamPost, closeTeamPost, lostFound + 4 more (~1757 tok)
- `EventController.php` — Agenda global de tous les événements à venir (+ passés récents). (~372 tok)
- `FriendshipController.php` — send, cancel, accept, reject, unfriend + 1 more (~915 tok)
- `HomeController.php` — Display the landing page with the 3 most recent articles. (~178 tok)
- `MajorCommentController.php` — store (~156 tok)
- `MajorController.php` — index, show (~159 tok)
- `MajorRatingController.php` — store (~177 tok)
- `MajorVideoController.php` — upload (~284 tok)
- `MessageController.php` — Boîte de réception : liste des conversations. (~1420 tok)
- `MyPostsController.php` — Display a paginated list of the logged‑in user's posts with comments. (~159 tok)
- `NotificationController.php` — index, open (~223 tok)
- `ParcoursController.php` — Présente l'offre de formation complète de l'ENSA Kénitra (~3565 tok)
- `PostController.php` — Display a listing of the resource. (~1441 tok)
- `ProfileController.php` — Show the profile edit form. (~283 tok)
- `RatingController.php` — Store or update a rating for a post by the authenticated user. (~271 tok)
- `RepostController.php` — Ajoute / retire un article des articles repostés sur le portfolio. (~156 tok)
- `SearchController.php` — Recherche globale : articles, filières, clubs et étudiants. (~370 tok)
- `SecureFileController.php` — Serves sensitive uploaded files (CVs, internship reports) from the (~317 tok)
- `StudentPortfolioController.php` — Génère un CV PDF propre à partir des données du portfolio. (~1392 tok)
- `TalentController.php` — Annuaire des talents — réservé aux recruteurs vérifiés (et aux admins). (~483 tok)

## app/Http/Controllers/Admin/

- `RecruiterController.php` — Serve the recruiter's work badge from the private disk. (~575 tok)

## app/Http/Middleware/

- `EnsureAdmin.php` — Handle an incoming request. (~145 tok)
- `EnsureUitDomain.php` — EnsureUitDomain: handle (~250 tok)
- `IsAdmin.php` — Handle an incoming request. (~208 tok)

## app/Http/Requests/

- `RegisterRequest.php` — Determine if the user is authorized to make this request. (~930 tok)

## app/Models/

- `Club.php` — Tous les membres du club (avec leur rôle via la table pivot). (~363 tok)
- `Comment.php` — Get the post that owns the comment. (~112 tok)
- `Event.php` — Étudiants inscrits à l'événement. (~216 tok)
- `FooterLink.php` — Model — table: footer_links, 3 fields, 1 scopes (~130 tok)
- `Friendship.php` — Model — 3 fields, 2 rels (~104 tok)
- `Internship.php` — Model — 8 fields, 1 rels (~88 tok)
- `JobOffer.php` — Model — 8 fields, 1 rels (~91 tok)
- `LostFoundItem.php` — Model — 9 fields, 1 rels (~107 tok)
- `Major.php` — Helper to compute average rating for the review system. (~354 tok)
- `MajorComment.php` — Model — 3 fields, 2 rels (~118 tok)
- `MajorRating.php` — Model — 3 fields, 2 rels (~118 tok)
- `Message.php` — Article partagé dans ce message (le cas échéant). (~294 tok)
- `Post.php` — Generate a unique slug from a title. (~956 tok)
- `Project.php` — Model — 9 fields, 1 rels (~109 tok)
- `Rating.php` — The user (reader) who gave the rating. (~147 tok)
- `Repost.php` — Model — 2 fields, 2 rels (~87 tok)
- `TeamPost.php` — Compétences sous forme de tableau. (~137 tok)
- `User.php` — Model — 18 fields, 13 rels (~2228 tok)
- `UserNotification.php` — Helper pour créer une notification (ignore si destinataire = expéditeur). (~237 tok)

## app/Policies/

- `UserPolicy.php` — Determine whether the user can view any models. (~412 tok)

## app/Providers/

- `AppServiceProvider.php` — Register any application services. (~852 tok)

## bootstrap/

- `app.php` (~216 tok)
- `providers.php` (~24 tok)

## bootstrap/cache/

- `.gitignore` — Git ignore rules (~4 tok)
- `packages.php` (~221 tok)
- `services.php` (~5839 tok)

## config/

- `app.php` (~1140 tok)
- `auth.php` (~1078 tok)
- `cache.php` (~983 tok)
- `database.php` (~1862 tok)
- `filesystems.php` (~676 tok)
- `logging.php` (~1158 tok)
- `mail.php` — Declares of (~969 tok)
- `queue.php` (~1120 tok)
- `services.php` — Declares of (~278 tok)
- `session.php` (~2093 tok)

## database/

- `.gitignore` — Git ignore rules (~3 tok)

## database/factories/

- `UserFactory.php` — Model factory: UserFactory (~279 tok)

## database/migrations/

- `0001_01_01_000000_create_users_table.php` — Run the migrations. (~393 tok)
- `0001_01_01_000001_create_cache_table.php` — Run the migrations. (~232 tok)
- `0001_01_01_000002_create_jobs_table.php` — Run the migrations. (~484 tok)
- `2026_06_01_223000_create_posts_table.php` — Run the migrations. (~184 tok)
- `2026_06_01_231020_create_comments_table.php` — Run the migrations. (~184 tok)
- `2026_06_01_234600_add_user_id_to_posts_table.php` — Run the migrations. (~207 tok)
- `2026_06_03_000001_create_footer_links_table.php` — Run the migrations. (~181 tok)
- `2026_06_04_130528_add_rating_to_posts_table.php` — Run the migrations. (~156 tok)
- `2026_06_04_131308_add_rating_to_posts_table.php` — Run the migrations. (~142 tok)
- `2026_06_04_234017_add_slug_to_posts_table.php` — Run the migrations. (~179 tok)
- `2026_06_04_234234_backfill_slugs_to_posts_table.php` — Run the migrations. (~238 tok)
- `2026_06_05_000001_add_views_to_posts_table.php` — Migration: alter posts table (~139 tok)
- `2026_06_05_000002_create_ratings_table.php` — Migration: create ratings table (~184 tok)
- `2026_06_10_202837_add_is_admin_to_users_table.php` — Migration: alter users table (~142 tok)
- `2026_06_10_203819_fix_major_comments_and_ratings_columns.php` — Migration: alter major_comments table (~526 tok)
- `2026_06_10_205141_create_clubs_table.php` — Migration: create clubs table (~160 tok)
- `2026_06_10_205841_add_details_to_clubs_table.php` — Migration: alter clubs table (~379 tok)
- `2026_06_10_215723_add_portfolio_fields_to_users_table.php` — Run the migrations. (~308 tok)
- `2026_06_10_215724_create_projects_table.php` — Run the migrations. (~286 tok)
- `2026_06_10_215726_create_internships_table.php` — Run the migrations. (~266 tok)
- `2026_06_10_222706_add_phone_privacy_to_users_table.php` — Run the migrations. (~164 tok)
- `2026_06_10_222708_create_friendships_table.php` — Run the migrations. (~232 tok)
- `2026_06_10_225019_add_account_type_to_users_table.php` — Run the migrations. (~249 tok)
- `2026_06_15_224125_create_club_user_table.php` — Run the migrations. (~276 tok)
- `2026_06_15_225617_create_events_table.php` — Run the migrations. (~358 tok)
- `2026_06_15_230116_create_messages_table.php` — Run the migrations. (~227 tok)
- `2026_06_15_230816_create_user_notifications_table.php` — Run the migrations. (~273 tok)
- `2026_06_16_163724_add_attachments_and_reposts.php` — Run the migrations. (~416 tok)
- `2026_06_16_163724_add_sharing_to_messages_and_create_reposts.php` — Run the migrations. (~404 tok)
- `2026_06_16_195637_create_ecosystem_tables.php` — Run the migrations. (~675 tok)

## database/seeders/

- `CategorySeeder.php` — CategorySeeder: run (~274 tok)
- `ClubMemberSeeder.php` — ClubMemberSeeder: run (~1215 tok)
- `ClubSeeder.php` — ClubSeeder: run (~2665 tok)
- `DatabaseSeeder.php` — Seed the application's database. (~11227 tok)
- `EcosystemSeeder.php` — EcosystemSeeder: run (~1159 tok)
- `EventSeeder.php` — EventSeeder: run (~1052 tok)
- `FooterLinkSeeder.php` — Run the database seeds. (~321 tok)
- `MajorSeeder.php` — MajorSeeder: run (~3748 tok)

## public/

- `.htaccess` — Apache configuration (~198 tok)
- `index.php` (~145 tok)
- `robots.txt` (~6 tok)

## public/css/

- `style.css` — Styles: 66 rules, 36 vars (~10300 tok)

## resources/css/

- `app.css` — /*.blade.php'; (~112 tok)

## resources/js/

- `app.js` (~7 tok)
- `bootstrap.js` (~37 tok)

## resources/views/

- `clubs.blade.php` — Blade: extends layouts.app, sections: title, content (~811 tok)
- `cookies.blade.php` — Blade: cookies (~391 tok)
- `home.blade.php` — Blade: extends layouts.app, sections: title, content (~3891 tok)
- `welcome.blade.php` — Blade: welcome (~22019 tok)

## resources/views/admin/

- `recruiters.blade.php` — Blade: extends layouts.app, sections: title, content (~3392 tok)

## resources/views/auth/

- `login.blade.php` — Blade: extends layouts.app, sections: title, content, 1 form(s) (~724 tok)
- `register.blade.php` — Blade: extends layouts.app, sections: title, content (~3982 tok)
- `verify-email.blade.php` — Blade: extends layouts.app, sections: title, content (~484 tok)

## resources/views/clubs/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~3361 tok)
- `show.blade.php` — Blade: extends layouts.app, sections: title, content (~9208 tok)

## resources/views/components/

- `cookie-banner.blade.php` — Blade: cookie-banner (~146 tok)

## resources/views/dashboard/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~2840 tok)

## resources/views/ecosystem/

- `ai-space.blade.php` — Blade: extends layouts.app, sections: title, content (~1572 tok)
- `career-center.blade.php` — Blade: extends layouts.app, sections: title, content (~2401 tok)
- `find-teammates.blade.php` — Blade: extends layouts.app, sections: title, content (~2268 tok)
- `lost-found.blade.php` — Blade: extends layouts.app, sections: title, content (~2330 tok)

## resources/views/errors/

- `403.blade.php` — Blade: extends layouts.app, sections: title, content (~440 tok)
- `404.blade.php` — Blade: extends layouts.app, sections: title, content (~481 tok)
- `419.blade.php` — Blade: extends layouts.app, sections: title, content (~463 tok)
- `500.blade.php` — Blade template (~481 tok)

## resources/views/events/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~2171 tok)

## resources/views/friends/

- `requests.blade.php` — Blade: extends layouts.app, sections: title, content (~3223 tok)

## resources/views/layouts/

- `app.blade.php` — Blade template (~7289 tok)

## resources/views/majors/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~727 tok)
- `show.blade.php` — Blade: extends layouts.app, sections: title, content (~9782 tok)

## resources/views/messages/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~4048 tok)
- `share.blade.php` — Blade: extends layouts.app, sections: title, content (~1810 tok)

## resources/views/notifications/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~1026 tok)

## resources/views/parcours/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~2795 tok)
- `show.blade.php` — Blade: extends layouts.app, sections: title, content (~1982 tok)

## resources/views/portfolio/

- `edit.blade.php` — Blade: extends layouts.app, sections: title, content (~8014 tok)
- `pdf.blade.php` — Blade template (~983 tok)
- `show.blade.php` — Blade: extends layouts.app, sections: title, content (~12518 tok)

## resources/views/posts/

- `create.blade.php` — Blade: extends layouts.app, sections: title, content, 1 form(s) (~1265 tok)
- `edit.blade.php` — Blade: extends layouts.app, sections: title, content, 1 form(s) (~1483 tok)
- `index.blade.php` — Blade: extends layouts.app, sections: title, content, 1 form(s) (~1836 tok)
- `MajorComment.php` — Model — 3 fields, 2 rels (~118 tok)
- `MajorRating.php` — Model — 3 fields, 2 rels (~118 tok)
- `MajorSeeder.php` — Database seeder: MajorSeeder (~869 tok)
- `my_posts.blade.php` — Blade: extends layouts.app, sections: title, content, 1 form(s), 1 table(s) (~1702 tok)
- `show.blade.php` — Blade: extends layouts.app, sections: title, content (~4411 tok)

## resources/views/profile/

- `edit.blade.php` — Blade: extends layouts.app, sections: title, content, 1 form(s) (~969 tok)

## resources/views/search/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~1882 tok)

## resources/views/talents/

- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~1934 tok)

## resources/views/vendor/pagination/

- `custom.blade.php` — Blade template (~451 tok)

## routes/

- `console.php` (~56 tok)
- `index.blade.php` — Blade: extends layouts.app, sections: title, content (~414 tok)
- `web.php` (~3714 tok)

## storage/app/

- `.gitignore` — Git ignore rules (~9 tok)

## storage/app/private/

- `.gitignore` — Git ignore rules (~4 tok)

## storage/app/public/

- `.gitignore` — Git ignore rules (~4 tok)

## storage/framework/

- `.gitignore` — Git ignore rules (~32 tok)

## storage/framework/cache/

- `.gitignore` — Git ignore rules (~6 tok)

## storage/framework/cache/data/

- `.gitignore` — Git ignore rules (~4 tok)

## storage/framework/sessions/

- `.gitignore` — Git ignore rules (~4 tok)

## storage/framework/testing/

- `.gitignore` — Git ignore rules (~4 tok)

## storage/framework/views/

- `.gitignore` — Git ignore rules (~4 tok)
- `0b8b39f827f1d9a62c59ef83e1cf5436.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1678 tok)
- `0c75dbf12ef5fda2c89387a0bbeab267.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1227 tok)
- `0f085284dac198466428281ec4ced95c.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~499 tok)
- `187dde00d813113d318088dabb6c2229.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~285 tok)
- `1a0a15c5a9fa943c2b7c71b68ea127de.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~150 tok)
- `1ad04418e81bf9e5a54d3317c9b7cac6.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~123 tok)
- `1b84e3a94bb1c5a1a5739d5b746c42d2.php` — total: totalPages, hasPrevious, hasNext, visiblePages (~6113 tok)
- `1d851e0309d1c82be90ba2982a6a592d.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~966 tok)
- `1f5e28cad276e516f83a6c9582bfff29.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\resources\views/majors/show.blade.php ENDPATH**/ ?> (~342 tok)
- `321f05a6e970d9d1e81b2f0f1832dac5.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~108 tok)
- `359e7556f1c5258d4bd5e7510d4d4bd0.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1075 tok)
- `35eb26ccadfc9077851ddf5b1736c233.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~878 tok)
- `379900a71bffaa1647fb137943ce5ec5.php` (~7994 tok)
- `3ff6711c3813f135e78ac99998fe7b37.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1204 tok)
- `452eeb43c8f27ba2801504d1fdba2164.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~574 tok)
- `5172e684d869e1d6b7722fe79827eebc.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~2943 tok)
- `59025bba2eb6514367c7acfe28a5fa3b.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1103 tok)
- `5a610a246c7873b0133a901bd1421d65.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~779 tok)
- `5eed896fddcdf1655dc63e9de53f49c8.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~359 tok)
- `60b72aa22959c893eaf82c0b2c5c1514.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~113 tok)
- `6398686f2b89482dcd8dc88a781c488d.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\resources\views/components/cookie-banner.blade.php ENDPATH**/ ?> (~180 tok)
- `64cd81bbabc56420ca4eb10e0ce54b71.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~825 tok)
- `706d5664d9a13e475b9faa1807681360.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~113 tok)
- `760cb46e95506790bc5130555dbf8b3a.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Exceptions/views/404.blade.php ENDPATH**... (~120 tok)
- `80dc7f564cf8935b69042bf59e8bd2a0.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~123 tok)
- `85ba42dfca28e081c95ae0d9a907477c.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~177 tok)
- `85c91dfbd318a1a73a2b5b12345d0f1f.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~817 tok)
- `88b0661380da0414dc7348f36ee4c680.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1143 tok)
- `8a9af467c6b31c6c9eb4cb2ea81658a8.php` — Interface: web (0 methods) (~5611 tok)
- `8ae0c6c04c6b9a4392c4aa270328011c.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~2872 tok)
- `92863420da9c2bd3cf952987dcffb583.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~703 tok)
- `afa9e1b606c417679fa3a3811101d102.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~271 tok)
- `b03fcdaccb45ce42adc1aa09d43870ae.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\resources\views/posts/show.blade.php ENDPATH**/ ?> (~2649 tok)
- `c901f86fd419f8eae3696cb848e68d9e.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~215 tok)
- `ca64e7fb4f576c4e3e8f208a5a31388b.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~248 tok)
- `d27ed79a6ff93dcfbde35966ddb79824.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~546 tok)
- `d3bcf70040965a3760ab9510959e69f1.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\resources\views/layouts/app.blade.php ENDPATH**/ ?> (~3274 tok)
- `de6d7967d9c642cf5b1900e82b577236.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~2757 tok)
- `e38535baf6d3d69b9a5ee980447e566f.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~863 tok)
- `e93c5eb5845f25010ee6f1d0ec588826.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~222 tok)
- `ec61e3c10dcc2da594b5eec099d558ac.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1229 tok)
- `ed33a7c29d29164b89c9a72de7f950c8.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Exceptions/views/minimal.blade.php ENDPA... (~1850 tok)
- `f01b99bb7736831d00ed9c52448b85dc.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~213 tok)
- `f3e6d98519e57ab1dca1c06055558c8e.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\resources\views/posts/index.blade.php ENDPATH**/ ?> (~2133 tok)
- `f7c8a785d03727655e29eba7d8431964.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~150 tok)
- `fee4548dd6a9760c815e32af0f3fcc77.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~2775 tok)
- `fff8469e954e9349ed15505298bc8282.php` — PATH C:\Users\HP\OneDrive\Documentos\laravelprojet\blog\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/render... (~1874 tok)

## storage/logs/

- `.gitignore` — Git ignore rules (~4 tok)

## tests/

- `TestCase.php` — Declares TestCase (~38 tok)

## tests/Feature/

- `AuthenticationTest.php` — AuthenticationTest: test_users_can_register, test_students_cannot_register_with_external_email, test (~529 tok)
- `CommentTest.php` — Test that comments can be displayed on a post details page. (~730 tok)
- `ExampleTest.php` — A basic test example. (~103 tok)
- `ProfileTest.php` — Test guest users are redirected to login. (~912 tok)
- `SecureFileTest.php` — The CV access rule is the most sensitive rule of the platform: (~974 tok)

## tests/Unit/

- `ExampleTest.php` — A basic test example. (~65 tok)

## vendor/

- `autoload.php` — autoload.php @generated by Composer (~200 tok)

## vendor/bin/

- `carbon` — Proxy PHP file generated by Composer (~888 tok)
- `carbon.bat` (~36 tok)
- `patch-type-declarations` — Proxy PHP file generated by Composer (~916 tok)
- `patch-type-declarations.bat` (~40 tok)
- `php-parse` — Proxy PHP file generated by Composer (~893 tok)
- `php-parse.bat` (~37 tok)
- `phpunit` — Proxy PHP file generated by Composer (~984 tok)
- `phpunit.bat` (~36 tok)
- `pint` — Proxy PHP file generated by Composer (~888 tok)
- `pint.bat` (~35 tok)
- `psysh` — Proxy PHP file generated by Composer (~884 tok)
- `psysh.bat` (~36 tok)
- `sail` — Support bash to support `source` with fallback on $0 if this does not run with bash (~253 tok)
- `sail.bat` (~41 tok)
- `var-dump-server` — Proxy PHP file generated by Composer (~908 tok)
- `var-dump-server.bat` (~38 tok)
- `yaml-lint` — Proxy PHP file generated by Composer (~898 tok)
- `yaml-lint.bat` (~37 tok)

## vendor/brick/math/

- `CHANGELOG.md` — Change log (~6389 tok)
- `composer.json` — PHP package manifest (~234 tok)
- `LICENSE` — Project license (~291 tok)

## vendor/brick/math/src/

- `BigDecimal.php` — An arbitrarily large decimal number. (~7764 tok)
- `BigInteger.php` — An arbitrarily large integer number. (~11510 tok)
- `BigNumber.php` — Base class for arbitrary-precision numbers. (~5854 tok)
- `BigRational.php` — An arbitrarily large rational number. (~4955 tok)
- `RoundingMode.php` — Specifies rounding behavior by defining how discarded digits affect the returned result when an exact value cannot (~1147 tok)

## vendor/brick/math/src/Exception/

- `DivisionByZeroException.php` — Exception thrown when a division by zero occurs. (~193 tok)
- `IntegerOverflowException.php` — Exception thrown when an integer overflow occurs. (~160 tok)
- `MathException.php` — Base class for all math exceptions. (~50 tok)
- `NegativeNumberException.php` — Exception thrown when attempting to perform an unsupported operation, such as a square root, on a negative number. (~68 tok)
- `NumberFormatException.php` — Exception thrown when attempting to create a number from a string with an invalid format. (~332 tok)
- `RoundingNecessaryException.php` — Exception thrown when a number cannot be represented at the requested scale without rounding. (~123 tok)

## vendor/brick/math/src/Internal/

- `Calculator.php` — Performs basic operations on arbitrary size integers. (~4996 tok)
- `CalculatorRegistry.php` — Stores the current Calculator instance used by BigNumber classes. (~504 tok)

## vendor/brick/math/src/Internal/Calculator/

- `BcMathCalculator.php` — Calculator implementation built around the bcmath library. (~454 tok)
- `GmpCalculator.php` — Calculator implementation built around the GMP library. (~835 tok)
- `NativeCalculator.php` — Calculator implementation using only native PHP code. (~3759 tok)

## vendor/carbonphp/carbon-doctrine-types/

- `composer.json` — PHP package manifest (~226 tok)
- `LICENSE` — Project license (~284 tok)
- `README.md` — Project documentation (~130 tok)

## vendor/carbonphp/carbon-doctrine-types/src/Carbon/Doctrine/

- `CarbonDoctrineType.php` — Interface: CarbonDoctrineType (3 methods) (~106 tok)
- `CarbonImmutableType.php` — Declares CarbonImmutableType (~41 tok)
- `CarbonType.php` — Declares CarbonType (~36 tok)
- `CarbonTypeConverter.php` — Trait: CarbonTypeConverter (~860 tok)
- `DateTimeDefaultPrecision.php` — Change the default Doctrine datetime and datetime_immutable precision. (~152 tok)
- `DateTimeImmutableType.php` — DateTimeImmutableType: use CarbonTypeConverter; (~209 tok)
- `DateTimeType.php` — DateTimeType: use CarbonTypeConverter; (~148 tok)

## vendor/composer/

- `autoload_classmap.php` — autoload_classmap.php @generated by Composer (~224158 tok)
- `autoload_files.php` — autoload_files.php @generated by Composer (~997 tok)
- `autoload_namespaces.php` — autoload_namespaces.php @generated by Composer (~38 tok)
- `autoload_psr4.php` — autoload_psr4.php @generated by Composer (~1890 tok)
- `autoload_real.php` — autoload_real.php @generated by Composer (~446 tok)
- `autoload_static.php` — autoload_static.php @generated by Composer (~245072 tok)
- `ClassLoader.php` — ClassLoader implements a PSR-0, PSR-4 and classmap class loader. (~4368 tok)
- `installed.json` (~93378 tok)
- `installed.php` (~13654 tok)
- `InstalledVersions.php` — This class is copied in every Composer installed project and available to all (~4639 tok)
- `LICENSE` — Project license (~286 tok)
- `platform_check.php` — platform_check.php @generated by Composer (~245 tok)

## vendor/dflydev/dot-access-data/

- `CHANGELOG.md` — Change log (~627 tok)
- `composer.json` — PHP package manifest (~513 tok)
- `LICENSE` — Project license (~286 tok)
- `README.md` — Project documentation (~978 tok)

## vendor/dflydev/dot-access-data/src/

- `Data.php` — Data: {@inheritdoc}, {@inheritdoc}, {@inheritdoc}, {@inheritdoc} + 9 more (~1798 tok)
- `DataInterface.php` — Append a value to a key (assumes key refers to an array value) (~936 tok)
- `Util.php` — Test if array is an associative array (~514 tok)

## vendor/dflydev/dot-access-data/src/Exception/

- `DataException.php` — Base runtime exception type thrown by this library (~111 tok)
- `InvalidPathException.php` — Thrown when trying to access an invalid path in the data array (~115 tok)
- `MissingPathException.php` — Thrown when trying to access a path that does not exist (~207 tok)

## vendor/doctrine/inflector/

- `composer.json` — PHP package manifest (~512 tok)
- `LICENSE` — Project license (~284 tok)
- `README.md` — Project documentation (~132 tok)

## vendor/doctrine/inflector/docs/en/

- `index.rst` (~1638 tok)

## vendor/doctrine/inflector/src/

- `CachedWordInflector.php` — CachedWordInflector: inflect (~137 tok)
- `GenericLanguageInflectorFactory.php` — Model factory: GenericLanguageInflectorFactory (~447 tok)
- `Inflector.php` — Inflector: private $singularizer;, Converts a word into the format for a Doctrine cla, Camelizes a word. This uses the classify() method , Uppercas... (~3376 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~451 tok)
- `Language.php` — Declares Language (~141 tok)
- `LanguageInflectorFactory.php` — Applies custom rules for singularisation (~215 tok)
- `NoopWordInflector.php` — NoopWordInflector: inflect (~54 tok)
- `RulesetInflector.php` — Inflects based on multiple rulesets. (~362 tok)
- `WordInflector.php` — Interface: WordInflector (1 methods) (~39 tok)

## vendor/doctrine/inflector/src/Rules/

- `Pattern.php` — Pattern: getPattern, getRegex, matches (~211 tok)
- `Patterns.php` — Patterns: matches (~161 tok)
- `Ruleset.php` — Ruleset: getRegular, getUninflected, getIrregular (~208 tok)
- `Substitution.php` — Substitution: getFrom, getTo (~121 tok)
- `Substitutions.php` — Substitutions: getFlippedSubstitutions, inflect (~366 tok)
- `Transformation.php` — Transformation: getPattern, getReplacement, inflect (~211 tok)
- `Transformations.php` — Transformations: inflect (~173 tok)
- `Word.php` — Word: getWord (~79 tok)

## vendor/doctrine/inflector/src/Rules/English/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~3184 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~123 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~234 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~1745 tok)

## vendor/doctrine/inflector/src/Rules/Esperanto/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~197 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~124 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~234 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~142 tok)

## vendor/doctrine/inflector/src/Rules/French/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~501 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~123 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~233 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~160 tok)

## vendor/doctrine/inflector/src/Rules/Italian/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~2235 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~123 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~234 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~459 tok)

## vendor/doctrine/inflector/src/Rules/NorwegianBokmal/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~252 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~126 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~236 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~164 tok)

## vendor/doctrine/inflector/src/Rules/Portuguese/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~1487 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~124 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~234 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~183 tok)

## vendor/doctrine/inflector/src/Rules/Spanish/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~490 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~123 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~234 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~164 tok)

## vendor/doctrine/inflector/src/Rules/Turkish/

- `Inflectible.php` — Inflectible: getSingular, getPlural, getIrregular (~266 tok)
- `InflectorFactory.php` — Model factory: InflectorFactory (~123 tok)
- `Rules.php` — Rules: getSingularRuleset, getPluralRuleset (~234 tok)
- `Uninflected.php` — Uninflected: getSingular, getPlural (~164 tok)

## vendor/doctrine/lexer/

- `composer.json` — PHP package manifest (~405 tok)
- `LICENSE` — Project license (~284 tok)
- `README.md` — Project documentation (~92 tok)
- `UPGRADE.md` — Upgrade to 3.0.0 (~241 tok)

## vendor/doctrine/lexer/src/

- `AbstractLexer.php` — Base class for writing simple lexers, i.e. for creating small DSLs. (~1986 tok)
- `Token.php` — Token: isA (~273 tok)

## vendor/dragonmantank/cron-expression/

- `CHANGELOG.md` — Change log (~1636 tok)
- `composer.json` — PHP package manifest (~364 tok)
- `LICENSE` — Project license (~306 tok)
- `README.md` — Project documentation (~1451 tok)

## vendor/dragonmantank/cron-expression/src/Cron/

- `AbstractField.php` — Abstract CRON expression field. (~2639 tok)
- `CronExpression.php` — CRON expression parser that can determine whether or not a CRON expression is (~5595 tok)
- `DayOfMonthField.php` — Day of month field.  Allows: * , / - ? L W. (~1303 tok)
- `DayOfWeekField.php` — Day of week field.  Allows: * / , - ? L #. (~1540 tok)
- `FieldFactory.php` — CRON field factory implementing a flyweight factory. (~381 tok)
- `FieldFactoryInterface.php` — Interface: FieldFactoryInterface (1 methods) (~33 tok)
- `FieldInterface.php` — CRON field interface. (~354 tok)
- `HoursField.php` — Hours field.  Allows: * , / -. (~1980 tok)
- `MinutesField.php` — Minutes field.  Allows: * , / -. (~721 tok)
- `MonthField.php` — Month field.  Allows: * , / -. (~357 tok)

## vendor/egulias/email-validator/

- `composer.json` — PHP package manifest (~268 tok)
- `CONTRIBUTING.md` — Contributing (~1628 tok)
- `LICENSE` — Project license (~286 tok)

## vendor/egulias/email-validator/src/

- `EmailLexer.php` — EmailLexer: class EmailLexer extends AbstractLexer, moveNext, Retrieve token type. Also processes the token valu, getAccumulatedValues + 3 more (~2320 tok)
- `EmailParser.php` — EmailParser: parse, getDomainPart, getLocalPart (~634 tok)
- `EmailValidator.php` — EmailValidator: private $lexer;, hasWarnings, getWarnings, getError (~330 tok)
- `MessageIDParser.php` — MessageIDParser: parse, getLeftPart, getRightPart (~627 tok)
- `Parser.php` — Parser: protected $warnings = []; (~477 tok)

## vendor/egulias/email-validator/src/Parser/

- `Comment.php` — Comment: parse (~842 tok)
- `DomainLiteral.php` — DomainLiteral: parse, checkIPV6Tag, convertIPv4ToIPv6 (~1912 tok)
- `DomainPart.php` — DomainPart: parse, domainPart (~2876 tok)
- `DoubleQuote.php` — DoubleQuote: parse (~854 tok)
- `FoldingWhiteSpace.php` — FoldingWhiteSpace: parse (~746 tok)
- `IDLeftPart.php` — IDLeftPart: parseComments (~103 tok)
- `IDRightPart.php` — IDRightPart: validateTokens (~260 tok)
- `LocalPart.php` — LocalPart: parse, localPart (~1453 tok)
- `PartParser.php` — PartParser: protected $warnings = []; (~411 tok)

## vendor/egulias/email-validator/src/Parser/CommentStrategy/

- `CommentStrategy.php` — Return "true" to continue, "false" to exit (~140 tok)
- `DomainComment.php` — DomainComment: exitCondition, endOfLoopValidations, getWarnings (~280 tok)
- `LocalComment.php` — LocalComment: exitCondition, endOfLoopValidations, getWarnings (~299 tok)

## vendor/egulias/email-validator/src/Result/

- `InvalidEmail.php` — InvalidEmail: isValid, isInvalid, description, code + 1 more (~225 tok)
- `MultipleErrors.php` — MultipleErrors: class MultipleErrors extends InvalidEmail, reason, description, code (~285 tok)
- `Result.php` — Is validation result valid? (~141 tok)
- `SpoofEmail.php` — Declares SpoofEmail (~82 tok)
- `ValidEmail.php` — ValidEmail: isValid, isInvalid, description, code (~102 tok)

## vendor/egulias/email-validator/src/Result/Reason/

- `AtextAfterCFWS.php` — AtextAfterCFWS: code, description (~70 tok)
- `CharNotAllowed.php` — CharNotAllowed: code, description (~69 tok)
- `CommaInDomain.php` — CommaInDomain: code, description (~74 tok)
- `CommentsInIDRight.php` — CommentsInIDRight: code, description (~78 tok)
- `ConsecutiveAt.php` — ConsecutiveAt: code, description (~70 tok)
- `ConsecutiveDot.php` — ConsecutiveDot: code, description (~70 tok)
- `CRLFAtTheEnd.php` — CRLFAtTheEnd: code, description (~88 tok)
- `CRLFX2.php` — CRLFX2: code, description (~69 tok)
- `CRNoLF.php` — CRNoLF: code, description (~67 tok)
- `DetailedReason.php` — Declares DetailedReason (~68 tok)
- `DomainAcceptsNoMail.php` — DomainAcceptsNoMail: code, description (~76 tok)
- `DomainHyphened.php` — DomainHyphened: code, description (~72 tok)
- `DomainTooLong.php` — DomainTooLong: code, description (~74 tok)
- `DotAtEnd.php` — DotAtEnd: code, description (~66 tok)
- `DotAtStart.php` — DotAtStart: code, description (~68 tok)
- `EmptyReason.php` — EmptyReason: code, description (~66 tok)
- `ExceptionFound.php` — ExceptionFound: code, description (~119 tok)
- `ExpectingATEXT.php` — ExpectingATEXT: code, description (~86 tok)
- `ExpectingCTEXT.php` — ExpectingCTEXT: code, description (~68 tok)
- `ExpectingDomainLiteralClose.php` — ExpectingDomainLiteralClose: code, description (~80 tok)
- `ExpectingDTEXT.php` — ExpectingDTEXT: code, description (~68 tok)
- `LabelTooLong.php` — LabelTooLong: code, description (~75 tok)
- `LocalOrReservedDomain.php` — LocalOrReservedDomain: code, description (~79 tok)
- `NoDNSRecord.php` — NoDNSRecord: code, description (~75 tok)
- `NoDomainPart.php` — NoDomainPart: code, description (~69 tok)
- `NoLocalPart.php` — NoLocalPart: code, description (~67 tok)
- `Reason.php` — Code for user land to act upon; (~76 tok)
- `RFCWarnings.php` — RFCWarnings: code, description (~72 tok)
- `SpoofEmail.php` — SpoofEmail: code, description (~80 tok)
- `UnableToGetDNSRecord.php` — Used on SERVFAIL, TIMEOUT or other runtime and network errors (~95 tok)
- `UnclosedComment.php` — UnclosedComment: code, description (~72 tok)
- `UnclosedQuotedString.php` — UnclosedQuotedString: code, description (~72 tok)
- `UnOpenedComment.php` — UnOpenedComment: code, description (~87 tok)
- `UnusualElements.php` — UnusualElements: code, description (~135 tok)

## vendor/egulias/email-validator/src/Validation/

- `DNSCheckValidation.php` — Reserved Top Level DNS Names (https://tools.ietf.org/html/rfc2606#section-2), (~1544 tok)
- `DNSGetRecordWrapper.php` — DNSGetRecordWrapper: getRecords (~230 tok)
- `DNSRecords.php` — DNSRecords: getRecords, withError (~136 tok)
- `EmailValidation.php` — Returns true if the given email is valid. (~210 tok)
- `MessageIDValidation.php` — MessageIDValidation: private $warnings = [];, getError (~347 tok)
- `MultipleValidationWithAnd.php` — If one of validations fails, the remaining validations will be skipped. (~753 tok)
- `NoRFCWarningsValidation.php` — NoRFCWarningsValidation: private $error;, {@inheritdoc} (~226 tok)
- `RFCValidation.php` — RFCValidation: private array $warnings = []; (~345 tok)

## vendor/egulias/email-validator/src/Validation/Exception/

- `EmptyValidationList.php` — Declares EmptyValidationList (~94 tok)

## vendor/egulias/email-validator/src/Validation/Extra/

- `SpoofCheckValidation.php` — SpoofCheckValidation: isValid, getError, getWarnings (~289 tok)

## vendor/egulias/email-validator/src/Warning/

- `AddressLiteral.php` — Declares AddressLiteral (~69 tok)
- `CFWSNearAt.php` — Declares CFWSNearAt (~61 tok)
- `CFWSWithFWS.php` — Declares CFWSWithFWS (~66 tok)
- `Comment.php` — Declares Comment (~58 tok)
- `DeprecatedComment.php` — Declares DeprecatedComment (~58 tok)
- `DomainLiteral.php` — Declares DomainLiteral (~65 tok)
- `EmailTooLong.php` — Declares EmailTooLong (~79 tok)
- `IPV6BadChar.php` — Declares IPV6BadChar (~69 tok)
- `IPV6ColonEnd.php` — Declares IPV6ColonEnd (~72 tok)
- `IPV6ColonStart.php` — Declares IPV6ColonStart (~73 tok)
- `IPV6Deprecated.php` — Declares IPV6Deprecated (~67 tok)
- `IPV6DoubleColon.php` — Declares IPV6DoubleColon (~70 tok)
- `IPV6GroupCount.php` — Declares IPV6GroupCount (~69 tok)
- `IPV6MaxGroups.php` — Declares IPV6MaxGroups (~74 tok)
- `LocalTooLong.php` — Declares LocalTooLong (~85 tok)
- `NoDNSMXRecord.php` — Declares NoDNSMXRecord (~72 tok)
- `ObsoleteDTEXT.php` — Declares ObsoleteDTEXT (~70 tok)
- `QuotedPart.php` — Declares QuotedPart (~163 tok)
- `QuotedString.php` — Declares QuotedString (~95 tok)
- `TLD.php` — Declares TLD (~52 tok)
- `Warning.php` — Warning: public const CODE = 0;, code, RFCNumber, __toString (~210 tok)

## vendor/fakerphp/faker/

- `CHANGELOG.md` — Change log (~2210 tok)
- `composer.json` — PHP package manifest (~471 tok)
- `LICENSE` — Project license (~316 tok)
- `README.md` — Project documentation (~945 tok)
- `rector-migrate.php` (~1001 tok)

## vendor/fakerphp/faker/src/

- `autoload.php` — Simple autoloader that follow the PHP Standards Recommendation #0 (PSR-0) (~236 tok)

## vendor/fakerphp/faker/src/Faker/

- `ChanceGenerator.php` — This generator returns a default value for all called properties (~381 tok)
- `DefaultGenerator.php` — This generator returns a default value for all called properties (~274 tok)
- `Documentor.php` — Documentor: getFormatters (~643 tok)
- `Factory.php` — Create a new generator (~545 tok)
- `Generator.php` — Generator: class Generator (~6146 tok)
- `UniqueGenerator.php` — Proxy for other generators that returns only unique values. (~623 tok)
- `ValidGenerator.php` — Proxy for other generators, to return only valid values. Works with (~568 tok)

## vendor/fakerphp/faker/src/Faker/Calculator/

- `Ean.php` — Utility class for validating EAN-8 and EAN-13 numbers (~302 tok)
- `Iban.php` — Generates IBAN Checksum (~431 tok)
- `Inn.php` — Inn: class Inn, Checks whether an INN has a valid checksum (~336 tok)
- `Isbn.php` — Utility class for validating ISBN-10 (~413 tok)
- `Luhn.php` — Utility class for generating and validating Luhn numbers. (~437 tok)
- `TCNo.php` — TCNo: class TCNo, Checks whether a TCNo has a valid checksum (~308 tok)

## vendor/fakerphp/faker/src/Faker/Container/

- `Container.php` — A simple implementation of a container. (~1000 tok)
- `ContainerBuilder.php` — is: final class ContainerBuilder, build, withDefaultExtensions (~500 tok)
- `ContainerException.php` — Declares is (~80 tok)
- `ContainerInterface.php` — Interface: ContainerInterface (0 methods) (~44 tok)
- `NotInContainerException.php` — Declares is (~81 tok)

## vendor/fakerphp/faker/src/Faker/Core/

- `Barcode.php` — is: ean13, ean8, isbn10, isbn13 (~339 tok)
- `Blood.php` — is: bloodType, bloodRh, bloodGroup (~219 tok)
- `Color.php` — is: final class Color implements Extension\ColorExtens, safeHexColor, rgbColorAsArray, rgbColor + 6 more (~1428 tok)
- `Coordinates.php` — is: final class Coordinates implements Extension\Exten, longitude, localCoordinates (~568 tok)
- `DateTime.php` — is: dateTime, dateTimeAD, dateTimeBetween, dateTimeInInterval + 17 more (~1682 tok)
- `File.php` — Declares is (~6323 tok)
- `Number.php` — is: numberBetween, randomDigit, randomDigitNot, randomDigitNotZero + 2 more (~523 tok)
- `Uuid.php` — is: uuid3 (~550 tok)
- `Version.php` — is: final class Version implements Extension\VersionEx (~564 tok)

## vendor/fakerphp/faker/src/Faker/Extension/

- `AddressExtension.php` — Interface: is (6 methods) (~204 tok)
- `BarcodeExtension.php` — Interface: is (4 methods) (~226 tok)
- `BloodExtension.php` — Interface: is (3 methods) (~141 tok)
- `ColorExtension.php` — Interface: is (10 methods) (~303 tok)
- `CompanyExtension.php` — Interface: is (3 methods) (~103 tok)
- `CountryExtension.php` — Interface: is (1 methods) (~69 tok)
- `DateTimeExtension.php` — FakerPHP extension for Date-related randomization. (~2471 tok)
- `Extension.php` — An extension is the only way to add new functionality to Faker. (~67 tok)
- `ExtensionNotFound.php` — Declares is (~56 tok)
- `FileExtension.php` — Interface: is (3 methods) (~146 tok)
- `GeneratorAwareExtension.php` — Interface: is (1 methods) (~131 tok)
- `GeneratorAwareExtensionTrait.php` — A helper trait to be used with GeneratorAwareExtension. (~128 tok)
- `Helper.php` — A class with some methods that may make building extensions easier. (~859 tok)
- `NumberExtension.php` — Interface: is (6 methods) (~371 tok)
- `PersonExtension.php` — Interface: is (8 methods) (~300 tok)
- `PhoneNumberExtension.php` — Interface: is (2 methods) (~98 tok)
- `UuidExtension.php` — Interface: is (1 methods) (~91 tok)
- `VersionExtension.php` — Interface: is (1 methods) (~168 tok)

## vendor/fakerphp/faker/src/Faker/Guesser/

- `Name.php` — Name: guessFormat (~1431 tok)

## vendor/fakerphp/faker/src/Faker/ORM/CakePHP/

- `ColumnTypeGuesser.php` — ColumnTypeGuesser: guessFormat (~593 tok)
- `EntityPopulator.php` — EntityPopulator: __get, __set, mergeColumnFormattersWith, mergeModifiersWith + 4 more (~1227 tok)
- `Populator.php` — Populator: getGenerator, getGuessers, removeGuesser, addGuesser + 2 more (~672 tok)

## vendor/fakerphp/faker/src/Faker/ORM/Doctrine/

- `backward-compatibility.php` (~109 tok)
- `ColumnTypeGuesser.php` — ColumnTypeGuesser: guessFormat (~717 tok)
- `EntityPopulator.php` — Service class for populating a table through a Doctrine Entity class. (~1967 tok)
- `Populator.php` — Service class for populating a database using the Doctrine ORM or ODM. (~954 tok)

## vendor/fakerphp/faker/src/Faker/ORM/Mandango/

- `ColumnTypeGuesser.php` — ColumnTypeGuesser: protected $generator; (~365 tok)
- `EntityPopulator.php` — Service class for populating a table through a Mandango ActiveRecord class. (~880 tok)
- `Populator.php` — Service class for populating a database using Mandango. (~510 tok)

## vendor/fakerphp/faker/src/Faker/ORM/Propel/

- `ColumnTypeGuesser.php` — ColumnTypeGuesser: guessFormat (~943 tok)
- `EntityPopulator.php` — Service class for populating a table through a Propel ActiveRecord class. (~1524 tok)
- `Populator.php` — Service class for populating a database using the Propel ORM. (~739 tok)

## vendor/fakerphp/faker/src/Faker/ORM/Propel2/

- `ColumnTypeGuesser.php` — ColumnTypeGuesser: guessFormat (~938 tok)
- `EntityPopulator.php` — Service class for populating a table through a Propel ActiveRecord class. (~1553 tok)
- `Populator.php` — Service class for populating a database using the Propel ORM. (~769 tok)

## vendor/fakerphp/faker/src/Faker/ORM/Spot/

- `ColumnTypeGuesser.php` — ColumnTypeGuesser constructor. (~608 tok)
- `EntityPopulator.php` — Service class for populating a table through a Spot Entity class. (~1355 tok)
- `Populator.php` — Service class for populating a database using the Spot ORM. (~690 tok)

## vendor/fakerphp/faker/src/Faker/Provider/

- `Address.php` — Address: citySuffix, streetSuffix, buildingNumber, city + 8 more (~953 tok)
- `Barcode.php` — Barcode: class Barcode extends Base, Get a random EAN8 barcode., Get a random ISBN-10 code, Get a random ISBN-13 code (~598 tok)
- `Base.php` — Base: protected $generator;, Returns a random number between 1 and 9, Generates a random digit, which cannot be $except, Returns a random integer w... (~6061 tok)
- `Biased.php` — Returns a biased integer between $min and $max (both inclusive). (~488 tok)
- `Color.php` — Color: hexColor, safeHexColor, rgbColorAsArray, rgbColor + 6 more (~1267 tok)
- `Company.php` — Company: company, companySuffix, jobTitle (~241 tok)
- `DateTime.php` — DateTime: protected static function getMaxTimestamp($max = ', Get a datetime object for a date between January 1, Get a datetime object for a date ... (~3303 tok)
- `File.php` — MIME types from the apache.org file. Some types are truncated. (~6856 tok)
- `HtmlLorem.php` — HtmlLorem: randomHtml (~2727 tok)
- `Image.php` — Depends on image generation from http://lorempixel.com/ (~1638 tok)
- `Internet.php` — Internet: protected static $localIpBlocks = [, final public function safeEmail(), companyEmail, freeEmailDomain + 11 more (~4454 tok)
- `Lorem.php` — Lorem: word, Generate an array of random words, Generate a random sentence, Generate an array of sentences + 3 more (~2103 tok)
- `Medical.php` — Medical: bloodType, bloodRh, bloodGroup (~173 tok)
- `Miscellaneous.php` — Miscellaneous: On date of 2017-03-26, md5, sha1, sha256 + 1 more (~3607 tok)
- `Payment.php` — Payment: protected static $cardParams = [, Returns the String of a credit card number., creditCardExpirationDate, creditCardExpirationDateString + ... (~2845 tok)
- `Person.php` — Person: name, firstName, firstNameMale, firstNameFemale + 4 more (~883 tok)
- `PhoneNumber.php` — PhoneNumber: protected static $e164Formats = [, e164PhoneNumber, International Mobile Equipment Identity (IMEI) (~1761 tok)
- `Text.php` — Generate a text string by the Markov chain algorithm. (~1816 tok)
- `UserAgent.php` — Possible processors on Linux (~2310 tok)
- `Uuid.php` — Generate name based md5 UUID (version 3). (~486 tok)

## vendor/fakerphp/faker/src/Faker/Provider/ar_EG/

- `Address.php` — Address: protected static $cityName = [, cityName, streetPrefix, secondaryAddress + 2 more (~2020 tok)
- `Color.php` — Declares Color (~354 tok)
- `Company.php` — Company: companyPrefix, catchPhrase, example 010101010, example 010101 (~545 tok)
- `Internet.php` — Internet: lastNameAscii, firstNameAscii, userName, domainName (~518 tok)
- `Payment.php` — International Bank Account Number (IBAN) (~87 tok)
- `Person.php` — Person: protected static $firstNameMale = [, nationalIdNumber (~2164 tok)
- `Text.php` — License: Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) (~2974 tok)

## vendor/fakerphp/faker/src/Faker/Provider/ar_JO/

- `Address.php` — Address: protected static $cityName = [, cityName, streetPrefix, secondaryAddress + 2 more (~1932 tok)
- `Company.php` — Company: companyPrefix, catchPhrase, bs (~414 tok)
- `Internet.php` — Internet: lastNameAscii, firstNameAscii, userName, domainName (~430 tok)
- `Person.php` — Declares Person (~3498 tok)
- `Text.php` — License: Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) (~26123 tok)

## vendor/fakerphp/faker/src/Faker/Provider/ar_SA/

- `Address.php` — Address: protected static $cityName = [, cityName, streetPrefix, secondaryAddress + 2 more (~2111 tok)
- `Color.php` — Declares Color (~1998 tok)
- `Company.php` — Company: companyPrefix, catchPhrase, bs, example 7001010101 (~480 tok)
- `Internet.php` — Internet: lastNameAscii, firstNameAscii, userName, domainName (~430 tok)
- `Payment.php` — International Bank Account Number (IBAN) (~182 tok)
- `Person.php` — Declares Person (~2892 tok)
- `Text.php` — License: Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) (~26123 tok)

## vendor/fakerphp/faker/src/Faker/Provider/at_AT/

- `Payment.php` — Declares Payment (~63 tok)

## vendor/fakerphp/faker/src/Faker/Provider/bg_BG/

- `Internet.php` — Declares Internet (~83 tok)
- `Payment.php` — International Bank Account Number (IBAN) (~373 tok)
- `Person.php` — Declares Person (~5659 tok)
- `PhoneNumber.php` — Declares PhoneNumber (~113 tok)

## vendor/fakerphp/faker/src/Faker/Provider/bn_BD/

- `Address.php` — Declares Address (~1953 tok)
- `Company.php` — Company: companyType, companyName (~144 tok)
- `Person.php` — Declares Person (~297 tok)
- `PhoneNumber.php` — PhoneNumber: phoneNumber (~71 tok)
- `Utils.php` — Utils: getBanglaNumber (~75 tok)

## vendor/fakerphp/faker/src/Faker/Provider/cs_CZ/

- `Address.php` — Source: https://cs.wikipedia.org/wiki/Seznam_m%C4%9Bst_v_%C4%8Cesku_podle_po%C4%8Dtu_obyvatel (~2339 tok)
- `Company.php` — Company: protected static $formats = [, Returns a random catch phrase attribute., Returns a random catch phrase verb., catchPhrase + 1 more (~940 tok)
- `DateTime.php` — Czech months and days without setting locale (~456 tok)
- `Internet.php` — Declares Internet (~85 tok)
- `Payment.php` — International Bank Account Number (IBAN) (~182 tok)
- `Person.php` — Declares Person (~8294 tok)
- `PhoneNumber.php` — Declares PhoneNumber (~70 tok)
- `Text.php` — License: PD old 70 (~122795 tok)

## vendor/fakerphp/faker/src/Faker/Provider/da_DK/

- `Address.php` — Declares Address (~4244 tok)
