<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Storage;

class RecruiterController extends Controller
{
    public function index()
    {
        $pending = User::where('account_type', 'recruiter')
            ->where('recruiter_status', 'pending')
            ->latest()
            ->get();

        $approved = User::where('account_type', 'recruiter')
            ->where('recruiter_status', 'approved')
            ->latest()
            ->get();

        $rejected = User::where('account_type', 'recruiter')
            ->where('recruiter_status', 'rejected')
            ->latest()
            ->get();

        return view('admin.recruiters', compact('pending', 'approved', 'rejected'));
    }

    public function approve(User $user)
    {
        abort_unless($user->account_type === 'recruiter', 404);
        $user->update(['recruiter_status' => 'approved']);

        UserNotification::send($user->id, 'Votre compte recruteur a été approuvé ✅', [
            'body'  => 'Vous pouvez désormais consulter les CV et l\'annuaire des talents.',
            'url'   => route('talents.index'),
            'icon'  => 'recruiter',
            'color' => '#059669',
        ]);

        return back()->with('success', $user->name . ' (' . $user->company_name . ') a été approuvé. Il peut désormais consulter les CV.');
    }

    public function reject(User $user)
    {
        abort_unless($user->account_type === 'recruiter', 404);
        $user->update(['recruiter_status' => 'rejected']);

        return back()->with('success', 'La demande de ' . $user->name . ' a été refusée.');
    }

    /**
     * Serve the recruiter's work badge from the private disk.
     * Route is behind the 'admin' middleware — only admins review badges.
     */
    public function badge(User $user)
    {
        abort_unless($user->account_type === 'recruiter' && $user->badge_path, 404);
        abort_unless(Storage::disk('local')->exists($user->badge_path), 404);

        return Storage::disk('local')->response($user->badge_path);
    }
}
