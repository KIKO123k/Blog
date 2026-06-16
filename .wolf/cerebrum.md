# Cerebrum

> OpenWolf's learning memory. Updated automatically as the AI learns from interactions.
> Do not edit manually unless correcting an error.
> Last updated: 2026-06-07

## User Preferences

- User communicates in casual/broken English. Be direct, avoid jargon, give short confirmations before big changes.

## Key Learnings

- **Project:** blog (Laravel 12)
- **Description:** <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red
- **Real controllers:** Auth, Club, Comment, Home, Major, MajorComment, MajorRating, MajorVideo, MyPosts, Post, Profile, Rating, Formation.
- **Real models:** User, Post, Comment, Rating, Major, MajorComment, MajorRating, FooterLink, Formation.
- **Views:** home, welcome, clubs, cookies, auth/ (login, register), posts/ (index, create, edit, show, my_posts), majors/ (index, show), profile/, formations/, components/, layouts/.
- **Features:** auth (incl. password reset), posts (comments/ratings/views/slug/categories), majors (comments/ratings/videos), clubs, formations, footer links, cookie banner.
- **Post slugs:** auto-generated on `creating` in `Post` model; all routes/views use slug binding (`route('posts.show', $post)`).
- **Ratings display:** views use `average_rating` from `withAvg('ratings')`, not legacy `posts.rating` column.
- **Categories:** `categories` + `category_post` tables; `CategorySeeder` seeds 6 defaults; filter chips on posts index; checkboxes on create/edit.
- **`.wolf/anatomy.md` is stale** — missed FormationController, MajorCommentController, MajorRatingController, MajorVideoController, and the formations views. Needs a rescan before fully trusting it.
- **JULES_REPORT.md** is unrelated boilerplate (mentions a VS Code extension repo). Ignore it for project context.
- **Account types (2026-06-10):** `users.account_type` is `student|recruiter`. Recruiters also have `company_name`, `badge_path`, `recruiter_status` (`pending|approved|rejected`). Helpers on `User`: `isStudent()`, `isRecruiter()`, `isVerifiedRecruiter()`, `cvVisibleTo(?User)`.
- **uit.ac.ma restriction is STUDENT-ONLY now.** Enforced in 3 places, all scoped to `account_type === 'student'`: `RegisterRequest` (conditional regex via `Rule::when`), `AuthController::login` (looks up user, skips check for recruiters), and `EnsureUitDomain` middleware. Recruiters register/login with any email domain.
- **CV access rule:** `User::cvVisibleTo($viewer)` — true only for the owner or a verified recruiter. Used in `portfolio/show.blade.php` for both the hero CV button and the sidebar contact CV row; others see a "réservé aux recruteurs" locked state.
- **Admin:** `is_admin` boolean gates the `admin` middleware alias (`EnsureAdmin`, registered in `bootstrap/app.php`). Admin user = `admin.ensa@uit.ac.ma` (seeder sets `is_admin=true`). Recruiter approval UI at `/admin/recruteurs`.
- **Friendships:** `friendships` table (`requester_id`, `receiver_id`, `status: pending|accepted|rejected`, unique pair). `User` helpers: `friendshipWith($id)`, `isFriendWith($id)`, `pendingRequestsCount()`. Phone visibility gated by `users.phone_privacy` (`public|friends|private`).
- **FIXED 2026-06-11 — private file delivery:** CVs/reports/badges now stored on the private `local` disk (`storage/app/private`) and served ONLY via `SecureFileController` (`files.cv`, `files.report` routes, auth + `UserPolicy@viewCv`) and `admin.recruiters.badge` (admin middleware). Never use `Storage::url()` or the `public` disk for these files — covered by `tests/Feature/SecureFileTest.php` (7 tests). Avatars and post images stay on the public disk (legitimately public).
- **Email verification active (2026-06-11):** `User implements MustVerifyEmail`, `Registered` event fired in AuthController@register, routes `verification.notice/verify/send`, soft banner in layout (non-blocking — no `verified` middleware applied). MAIL_MAILER=log → links land in storage/logs/laravel.log. Existing accounts were backfilled verified.
- **Custom error pages exist:** errors/404, 403, 419 (extend layouts.app) and 500 (standalone HTML on purpose — must not depend on layout/DB).
- XSS audit clean: `{!! !!}` uses are `e()`-escaped or hardcoded SVGs.

## Do-Not-Repeat

<!-- Mistakes made and corrected. Each entry prevents the same mistake recurring. -->
<!-- Format: [YYYY-MM-DD] Description of what went wrong and what to do instead. -->

[2026-06-07] Post routes use slug binding but tests/views used numeric ID — always use `$post` or `$post->slug` in routes and tests.
[2026-06-07] Star ratings in views referenced `$post->rating` (legacy column) instead of `$post->average_rating` from the ratings relation.
[2026-06-07] `Post::insert()` in DatabaseSeeder bypasses model events — bulk-seeded posts had null slugs; call `Post::backfillMissingSlugs()` after bulk insert.
[2026-06-10] Do NOT stack multiple single-line inline `@if(...)...@endif` directives on consecutive lines to build a meta string (e.g. filiere · promotion) — Blade mis-compiles and throws "unexpected endforeach, expecting endif". Build the string in one `@php` block with `array_filter` + `implode(' · ', ...)` and echo once.
[2026-06-15] Do NOT define a static method named `push()` on an Eloquent model — `push()` is reserved (saves model + relations) and PHP fatals: "Cannot make non static method Model::push() static". Used `UserNotification::send()` instead.
[2026-06-15] Two controllers named `DashboardController` exist (`App\Http\Controllers\DashboardController` = student, `App\Http\Controllers\Admin\DashboardController` = admin). When importing both in routes/web.php, alias one (`use ... as StudentDashboardController`) or PHP fatals on duplicate import name.
[2026-06-11] When adding `Gate::`, `Storage::`, etc. to a controller, ALWAYS add the facade import — `Gate::allows()` without `use Illuminate\Support\Facades\Gate;` resolves to `App\Http\Controllers\Gate` → fatal 500 (hit PostController edit/update/delete in production paths).
[2026-06-11] Test users created via `User::factory()` get `@example.com` emails — student accounts get logged out by `EnsureUitDomain` mid-test. Always give test students a `@uit.ac.ma` email; recruiters may keep any domain.

## Decision Log

<!-- Significant technical decisions with rationale. Why X was chosen over B. -->

[2026-06-10] **Recruiter verification = admin approval (not automatic).** User chose: recruiters register with company name + work-badge photo → status `pending` → an admin reviews the badge at `/admin/recruteurs` and approves/rejects. Only `approved` recruiters can see CVs. Rationale: "vérifier si vrai recruteur" implies a human check; auto-approval would let anyone upload any image and claim recruiter status.
[2026-06-10] **CV visibility = verified recruiters + owner.** User chose: the CV download is shown only to verified recruiters and the student owner (on their own page). Other students and guests see a locked "réservé aux recruteurs" badge. Implemented via `User::cvVisibleTo()` rather than scattering the check in views.
