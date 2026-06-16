<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Annuaire des talents — réservé aux recruteurs vérifiés (et aux admins).
 * Permet de parcourir et filtrer tous les portfolios étudiants.
 */
class TalentController extends Controller
{
    public function index(Request $request)
    {
        $viewer = $request->user();
        abort_unless($viewer && ($viewer->isVerifiedRecruiter() || $viewer->is_admin), 403,
            'Réservé aux recruteurs vérifiés.');

        $query = User::where('account_type', 'student');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")
                ->orWhere('filiere', 'like', "%{$term}%")
                ->orWhere('bio', 'like', "%{$term}%"));
        }

        if ($request->filled('filiere')) {
            $query->where('filiere', $request->filiere);
        }

        if ($request->filled('promotion')) {
            $query->where('promotion', $request->promotion);
        }

        if ($request->boolean('with_cv')) {
            $query->whereNotNull('cv_path');
        }

        $students = $query->withCount(['projects', 'internships'])
            ->orderByDesc('cv_path')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        // Listes pour les filtres
        $filieres = User::where('account_type', 'student')
            ->whereNotNull('filiere')->distinct()->orderBy('filiere')->pluck('filiere');
        $promotions = User::where('account_type', 'student')
            ->whereNotNull('promotion')->distinct()->orderByDesc('promotion')->pluck('promotion');

        return view('talents.index', compact('students', 'filieres', 'promotions'));
    }
}
