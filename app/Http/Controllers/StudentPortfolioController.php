<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentPortfolioController extends Controller
{
    public function show(User $user)
    {
        $user->load([
            'posts' => fn($q) => $q->latest()->take(3),
            'projects',
            'internships',
            'reposts' => fn($q) => $q->with('user')->take(6),
        ]);
        return view('portfolio.show', compact('user'));
    }

    /** Génère un CV PDF propre à partir des données du portfolio. */
    public function pdf(User $user)
    {
        $user->load(['projects', 'internships']);
        $isOwner = Auth::id() === $user->id;

        $pdf = Pdf::loadView('portfolio.pdf', compact('user', 'isOwner'))->setPaper('a4');
        $filename = 'CV-' . preg_replace('/\s+/', '-', $user->name) . '.pdf';

        return $pdf->download($filename);
    }

    public function edit()
    {
        $user = Auth::user();
        $user->load(['projects', 'internships']);
        return view('portfolio.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'bio'          => 'nullable|string|max:1000',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url'   => 'nullable|url|max:255',
            'phone'         => 'nullable|string|max:20',
            'phone_privacy' => 'nullable|in:public,friends,private',
            'filiere'      => 'nullable|string|max:100',
            'promotion'    => 'nullable|integer|min:2000|max:2040',
            'avatar'       => 'nullable|image|max:2048',
            'cv'           => 'nullable|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['bio','linkedin_url','github_url','phone','phone_privacy','filiere','promotion']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) Storage::disk('public')->delete($user->avatar_path);
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('cv')) {
            // CVs live on the private disk — served only through SecureFileController
            if ($user->cv_path) Storage::disk('local')->delete($user->cv_path);
            $data['cv_path'] = $request->file('cv')->store('cvs', 'local');
        }

        $user->update($data);

        return redirect()->route('portfolio.edit')->with('success', 'Portfolio mis à jour avec succès !');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:2000',
            'technologies' => 'nullable|string',
            'github_url'   => 'nullable|url',
            'demo_url'     => 'nullable|url',
            'year'         => 'nullable|integer|min:2000|max:2040',
            'type'         => 'required|in:academique,personnel,stage',
        ]);

        $techs = array_filter(array_map('trim', explode(',', $request->technologies ?? '')));

        Auth::user()->projects()->create([
            'title'        => $request->title,
            'description'  => $request->description,
            'technologies' => $techs ?: null,
            'github_url'   => $request->github_url,
            'demo_url'     => $request->demo_url,
            'year'         => $request->year,
            'type'         => $request->type,
        ]);

        return back()->with('success', 'Projet ajouté !');
    }

    public function destroyProject(Project $project)
    {
        abort_if($project->user_id !== Auth::id(), 403);
        $project->delete();
        return back()->with('success', 'Projet supprimé.');
    }

    public function storeInternship(Request $request)
    {
        $request->validate([
            'company'     => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'period'      => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
            'year'        => 'nullable|integer|min:2000|max:2040',
            'type'        => 'required|in:observation,execution,pfe',
            'report'      => 'nullable|mimes:pdf|max:10240',
        ]);

        $data = $request->only(['company','position','period','description','year','type']);

        if ($request->hasFile('report')) {
            // Reports live on the private disk — served only through SecureFileController
            $data['report_path'] = $request->file('report')->store('reports', 'local');
        }

        Auth::user()->internships()->create($data);

        return back()->with('success', 'Stage ajouté !');
    }

    public function destroyInternship(Internship $internship)
    {
        abort_if($internship->user_id !== Auth::id(), 403);
        if ($internship->report_path) Storage::disk('local')->delete($internship->report_path);
        $internship->delete();
        return back()->with('success', 'Stage supprimé.');
    }
}
