<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUitDomain
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Recruiters use external company emails — the uit.ac.ma rule applies to students only.
            if ($user->account_type === 'student'
                && !preg_match('/^.+@([a-zA-Z0-9\-]+\.)*uit\.ac\.ma$/i', $user->email)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte n\'est pas autorisé sur cette plateforme. Seuls les emails @uit.ac.ma sont acceptés.',
                ]);
            }
        }

        return $next($request);
    }
}
