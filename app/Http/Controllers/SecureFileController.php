<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

/**
 * Serves sensitive uploaded files (CVs, internship reports) from the
 * private disk, after an authorization check. These files must never
 * be reachable through the public /storage symlink.
 */
class SecureFileController extends Controller
{
    /**
     * CV — owner or verified recruiter only (see UserPolicy@viewCv).
     */
    public function cv(User $user)
    {
        abort_unless($user->cv_path, 404);
        Gate::authorize('viewCv', $user);

        abort_unless(Storage::disk('local')->exists($user->cv_path), 404);

        return Storage::disk('local')->response($user->cv_path, 'CV-' . str()->slug($user->name) . '.pdf');
    }

    /**
     * Internship report — any authenticated user (route is auth-gated).
     */
    public function report(Internship $internship)
    {
        abort_unless($internship->report_path, 404);
        abort_unless(Storage::disk('local')->exists($internship->report_path), 404);

        return Storage::disk('local')->response($internship->report_path);
    }
}
