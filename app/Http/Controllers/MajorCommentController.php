<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Http\Requests\StoreMajorCommentRequest;
use Illuminate\Http\Request;

class MajorCommentController extends Controller
{
    public function store(StoreMajorCommentRequest $request, $id)
    {
        $major = Major::findOrFail($id);

        $validated = $request->validated();

        $major->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Votre commentaire a été publié avec succès !');
    }
}
