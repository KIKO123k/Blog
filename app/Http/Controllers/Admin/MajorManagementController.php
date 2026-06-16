<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MajorManagementController extends Controller
{
    /**
     * Display a listing of the majors.
     */
    public function index()
    {
        $majors = Major::latest()->paginate(10);
        return view('admin.majors.index', compact('majors'));
    }

    /**
     * Show the form for creating a new major.
     */
    public function create()
    {
        return view('admin.majors.create');
    }

    /**
     * Store a newly created major in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:formations,slug',
            'category'    => 'required|string|max:255',
            'description' => 'required|string',
            'source_url'  => 'required|url',
            'video_url'   => 'nullable|url',
        ]);

        Major::create([
            'title'       => $request->title,
            'slug'        => $request->slug ?: Str::slug($request->title),
            'category'    => $request->category,
            'description' => $request->description,
            'source_url'  => $request->source_url,
            'video_url'   => $request->video_url,
        ]);

        return redirect()->route('admin.majors.index')->with('success', 'Filière créée avec succès.');
    }

    /**
     * Show the form for editing the specified major.
     */
    public function edit(Major $major)
    {
        return view('admin.majors.edit', compact('major'));
    }

    /**
     * Update the specified major in storage.
     */
    public function update(Request $request, Major $major)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:formations,slug,' . $major->id,
            'category'    => 'required|string|max:255',
            'description' => 'required|string',
            'source_url'  => 'required|url',
            'video_url'   => 'nullable|url',
        ]);

        $major->update([
            'title'       => $request->title,
            'slug'        => $request->slug,
            'category'    => $request->category,
            'description' => $request->description,
            'source_url'  => $request->source_url,
            'video_url'   => $request->video_url,
        ]);

        return redirect()->route('admin.majors.index')->with('success', 'Filière mise à jour avec succès.');
    }

    /**
     * Remove the specified major from storage.
     */
    public function destroy(Major $major)
    {
        $major->delete();
        return redirect()->route('admin.majors.index')->with('success', 'Filière supprimée avec succès.');
    }
}
