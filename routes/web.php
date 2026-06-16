<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyPostsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MajorCommentController;
use App\Http\Controllers\MajorRatingController;
use App\Http\Controllers\MajorVideoController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\StudentPortfolioController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\EcosystemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController as StudentDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\MajorManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/clubs/{club}', [ClubController::class, 'show'])->name('clubs.show');

// --- Public Category Filter ---
Route::get('categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// --- Offre de formation complète (prépa, master, doctorat, double diplôme, mobilité, partenaires) ---
Route::get('/parcours', [ParcoursController::class, 'index'])->name('parcours.index');
Route::get('/parcours/{slug}', [ParcoursController::class, 'show'])->name('parcours.show');

// --- Majors Routes ---
Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
Route::get('/majors/{slug}', [MajorController::class, 'show'])->name('majors.show');
Route::middleware('auth')->group(function () {
    Route::post('/majors/{id}/comments', [MajorCommentController::class, 'store'])->name('majors.comments.store');
    Route::post('/majors/{id}/rate', [MajorRatingController::class, 'store'])->name('majors.rate');
    Route::post('/majors/{id}/review', [MajorController::class, 'storeComment'])->name('majors.review.store');
    Route::post('/majors/{id}/video', [MajorVideoController::class, 'upload'])->name('majors.video.upload');
});

// --- Guest Only Routes (Login / Register / Forgot Password) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:auth');

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:auth');

    // --- Password Reset ---
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:auth')->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// --- Authenticated Authors Only Routes ---
Route::middleware('auth')->group(function () {
    // CRUD Create/Edit/Store/Update/Destroy operations
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Tableau de bord personnel
    Route::get('tableau-de-bord', [StudentDashboardController::class, 'index'])->name('dashboard');

    // My Articles page
    Route::get('my-articles', [MyPostsController::class, 'index'])->name('my-articles');

    // Profile operations
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Secure POST logout route
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Original post detail route (uses slug via Post model's getRouteKeyName)
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// --- Annuaire des talents (recruteurs vérifiés) ---
Route::get('/talents', [TalentController::class, 'index'])->middleware('auth')->name('talents.index');

// --- Événements & agenda des clubs ---
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::post('/events/{event}/rsvp', [EventController::class, 'toggleRsvp'])->middleware('auth')->name('events.rsvp');

// --- Student Portfolios ---
Route::get('/students/{user}/cv.pdf', [StudentPortfolioController::class, 'pdf'])->name('portfolio.pdf');
Route::get('/students/{user}', [StudentPortfolioController::class, 'show'])->name('portfolio.show');

Route::middleware('auth')->group(function () {
    Route::get('/portfolio/edit',                    [StudentPortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/edit',                    [StudentPortfolioController::class, 'update'])->name('portfolio.update');
    Route::post('/portfolio/projects',               [StudentPortfolioController::class, 'storeProject'])->name('portfolio.projects.store');
    Route::delete('/portfolio/projects/{project}',   [StudentPortfolioController::class, 'destroyProject'])->name('portfolio.projects.destroy');
    Route::post('/portfolio/internships',            [StudentPortfolioController::class, 'storeInternship'])->name('portfolio.internships.store');
    Route::delete('/portfolio/internships/{internship}', [StudentPortfolioController::class, 'destroyInternship'])->name('portfolio.internships.destroy');
});

// --- Notifications ---
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'open'])->name('notifications.open');
});

// --- Partage d'article & repost portfolio ---
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/repost',   [RepostController::class, 'toggle'])->name('posts.repost');
    Route::get('/posts/{post}/partager',  [MessageController::class, 'shareForm'])->name('posts.share.form');
    Route::post('/posts/{post}/partager', [MessageController::class, 'sharePost'])->name('posts.share');
});

// --- Messagerie privée ---
Route::middleware('auth')->group(function () {
    Route::get('/messages',            [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}',     [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}',    [MessageController::class, 'store'])->name('messages.store');
});

// --- Friends / Social ---
Route::middleware('auth')->group(function () {
    Route::get('/friends/requests',              [FriendshipController::class, 'requests'])->name('friends.requests');
    Route::post('/friends/send/{user}',          [FriendshipController::class, 'send'])->name('friends.send');
    Route::post('/friends/cancel/{user}',        [FriendshipController::class, 'cancel'])->name('friends.cancel');
    Route::post('/friends/accept/{user}',        [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/reject/{user}',        [FriendshipController::class, 'reject'])->name('friends.reject');
    Route::delete('/friends/unfriend/{user}',    [FriendshipController::class, 'unfriend'])->name('friends.unfriend');
});

// --- Admin Routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Recruiter Verification
    Route::get('/recruteurs',                 [RecruiterController::class, 'index'])->name('recruiters');
    Route::post('/recruteurs/{user}/approve', [RecruiterController::class, 'approve'])->name('recruiters.approve');
    Route::post('/recruteurs/{user}/reject',  [RecruiterController::class, 'reject'])->name('recruiters.reject');
    Route::get('/recruteurs/{user}/badge',    [RecruiterController::class, 'badge'])->name('recruiters.badge');

    // Admin Post Management
    Route::get('/posts', [PostManagementController::class, 'index'])->name('posts.index');
    Route::delete('/posts/{post}', [PostManagementController::class, 'destroy'])->name('posts.destroy');

    // Admin Category Management
    Route::get('/categories', [CategoryManagementController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryManagementController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryManagementController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryManagementController::class, 'destroy'])->name('categories.destroy');

    // Admin User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // Admin Major Management
    Route::resource('majors', MajorManagementController::class);
});

// --- Secure file delivery (private disk, authorization enforced) ---
Route::middleware('auth')->group(function () {
    Route::get('/files/cv/{user}',            [App\Http\Controllers\SecureFileController::class, 'cv'])->name('files.cv');
    Route::get('/files/report/{internship}',  [App\Http\Controllers\SecureFileController::class, 'report'])->name('files.report');
});

// --- Email verification ---
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/')->with('success', 'Votre adresse e-mail a été vérifiée avec succès !');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Un nouveau lien de vérification vous a été envoyé.');
    })->middleware('throttle:6,1')->name('verification.send');
});

// Static pages (required for seeders)
Route::get('cookies', fn() => view('cookies'))->name('cookies');

// --- Comments Route (public) ---
Route::post('posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('throttle:comments')
    ->name('comments.store');

// --- Rating Route (auth required) ---
Route::middleware('auth')->group(function () {
    Route::post('posts/{post}/rating', [RatingController::class, 'store'])
        ->middleware('throttle:ratings')
        ->name('ratings.store');
});

// --- Formations ---
Route::prefix('formations')->name('formations.')->group(function () {
    Route::get('/',       [FormationController::class, 'index'])->name('index');
    Route::get('/{slug}', [FormationController::class, 'show'])->name('show');
});

// --- Écosystème étudiant (pages Laravel natives) ---
Route::get('/ecosystem/ai-space',        [EcosystemController::class, 'aiSpace'])->name('ecosystem.ai');
Route::get('/ecosystem/find-teammates',  [EcosystemController::class, 'findTeammates'])->name('ecosystem.teammates');
Route::get('/ecosystem/lost-found',      [EcosystemController::class, 'lostFound'])->name('ecosystem.lostfound');
Route::get('/ecosystem/career-center',   [EcosystemController::class, 'careerCenter'])->name('ecosystem.career');

Route::middleware('auth')->group(function () {
    Route::post('/ecosystem/find-teammates',          [EcosystemController::class, 'storeTeamPost'])->name('ecosystem.teammates.store');
    Route::post('/ecosystem/team-posts/{teamPost}/close', [EcosystemController::class, 'closeTeamPost'])->name('ecosystem.teammates.close');
    Route::post('/ecosystem/lost-found',              [EcosystemController::class, 'storeLostFound'])->name('ecosystem.lostfound.store');
    Route::post('/ecosystem/lost-found/{item}/resolve', [EcosystemController::class, 'resolveLostFound'])->name('ecosystem.lostfound.resolve');
    Route::post('/ecosystem/career-center',           [EcosystemController::class, 'storeJobOffer'])->name('ecosystem.career.store');
});

