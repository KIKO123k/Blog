<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\LostFoundItem;
use App\Models\Major;
use App\Models\Post;
use App\Models\TeamPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EcosystemController extends Controller
{
    /* ===================== Assistant d'étude ===================== */

    public function aiSpace(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $articles = collect();
        $majors = collect();

        if (mb_strlen($q) >= 2) {
            $like = "%{$q}%";
            $articles = Post::where('title', 'like', $like)
                ->orWhere('content', 'like', $like)
                ->latest()->limit(5)->get();
            $majors = Major::where('title', 'like', $like)
                ->orWhere('description', 'like', $like)->limit(3)->get();
        }

        // Suggestions rapides
        $suggestions = ['Git & GitHub', 'Bases de données', 'Python', 'Intelligence Artificielle', 'Préparer un entretien', 'Réseaux & TCP/IP'];

        return view('ecosystem.ai-space', compact('q', 'articles', 'majors', 'suggestions'));
    }

    /* ===================== Find Teammates ===================== */

    public function findTeammates(Request $request)
    {
        $query = TeamPost::with('user')->where('status', 'open');

        if ($request->filled('filiere')) {
            $query->where('filiere', $request->filiere);
        }
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($w) => $w->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('skills_needed', 'like', "%{$term}%"));
        }

        $posts = $query->latest()->paginate(9)->withQueryString();
        $filieres = TeamPost::whereNotNull('filiere')->distinct()->orderBy('filiere')->pluck('filiere');

        return view('ecosystem.find-teammates', compact('posts', 'filieres'));
    }

    public function storeTeamPost(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string|max:2000',
            'skills_needed' => 'nullable|string|max:255',
            'filiere'       => 'nullable|string|max:100',
            'team_size'     => 'nullable|integer|min:2|max:10',
        ]);

        $request->user()->teamPosts()->create($request->only(
            'title', 'description', 'skills_needed', 'filiere', 'team_size'
        ));

        return back()->with('success', 'Votre annonce de recherche de coéquipiers a été publiée !');
    }

    public function closeTeamPost(TeamPost $teamPost)
    {
        abort_unless($teamPost->user_id === auth()->id(), 403);
        $teamPost->update(['status' => 'closed']);
        return back()->with('success', 'Annonce clôturée.');
    }

    /* ===================== Lost & Found ===================== */

    public function lostFound(Request $request)
    {
        $query = LostFoundItem::with('user')->where('status', 'open');

        if (in_array($request->type, ['lost', 'found'])) {
            $query->where('type', $request->type);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($w) => $w->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('location', 'like', "%{$term}%"));
        }

        $items = $query->latest()->paginate(12)->withQueryString();

        return view('ecosystem.lost-found', compact('items'));
    }

    public function storeLostFound(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:lost,found',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1500',
            'category'    => 'required|string|max:50',
            'location'    => 'nullable|string|max:150',
            'item_date'   => 'nullable|date',
            'image'       => 'nullable|image|max:4096',
        ]);

        $data = $request->only('type', 'title', 'description', 'category', 'location', 'item_date');
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('lostfound', 'public');
        }

        $request->user()->lostFoundItems()->create($data);

        return back()->with('success', 'Votre signalement a été publié. Merci !');
    }

    public function resolveLostFound(LostFoundItem $item)
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $item->update(['status' => 'resolved']);
        return back()->with('success', 'Marqué comme résolu. 🎉');
    }

    /* ===================== Career Center ===================== */

    public function careerCenter(Request $request)
    {
        $query = JobOffer::with('poster');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($w) => $w->where('title', 'like', "%{$term}%")
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('domain', 'like', "%{$term}%"));
        }

        $offers = $query->latest()->paginate(10)->withQueryString();
        $canPost = auth()->check() && (auth()->user()->isVerifiedRecruiter() || auth()->user()->is_admin);

        return view('ecosystem.career-center', compact('offers', 'canPost'));
    }

    public function storeJobOffer(Request $request)
    {
        abort_unless(auth()->user()->isVerifiedRecruiter() || auth()->user()->is_admin, 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'type'        => 'required|in:stage,pfe,emploi,alternance',
            'location'    => 'nullable|string|max:150',
            'description' => 'nullable|string|max:2000',
            'apply_url'   => 'nullable|url|max:255',
            'domain'      => 'nullable|string|max:100',
        ]);

        $data = $request->only('title', 'company', 'type', 'location', 'description', 'apply_url', 'domain');
        $data['posted_by'] = auth()->id();
        JobOffer::create($data);

        return back()->with('success', 'Offre publiée avec succès !');
    }
}
