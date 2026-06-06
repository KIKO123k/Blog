<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\MajorRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajorRatingController extends Controller
{
    public function store(Request $request, $id)
    {
        $major = Formation::findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        MajorRating::updateOrCreate(
            ['user_id' => Auth::id(), 'major_id' => $major->id],
            ['rating' => $validated['rating']]
        );

        return redirect()->back()->with('success', 'Merci pour votre note !');
    }
}
