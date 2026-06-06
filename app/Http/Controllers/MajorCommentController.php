<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class MajorCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $major = Formation::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $major->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Votre commentaire a été publié avec succès !');
    }
}
