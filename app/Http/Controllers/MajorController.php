<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\MajorComment;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::with('comments')->get();
        return view('majors.index', compact('majors'));
    }

    public function show(string $slug)
    {
        $major = Major::where('slug', $slug)->with(['comments.user', 'ratings'])->firstOrFail();
        $userRating = auth()->check() 
            ? $major->ratings()->where('user_id', auth()->id())->first() 
            : null;
            
        return view('majors.show', compact('major', 'userRating'));
    }

    /**
     * Handle submitting a combined comment & rating (Review System).
     */
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        // We use the authenticated user's ID
        MajorComment::create([
            'major_id' => $id,
            'user_id'  => auth()->id(),
            'rating'   => $request->rating,
            'content'  => $request->content,
        ]);

        // Optional: Also sync with your MajorRating table if you want to keep them separate
        // MajorRating::updateOrCreate(['major_id' => $id, 'user_id' => auth()->id()], ['rating' => $request->rating]);

        return back()->with('success', 'Votre avis a été ajouté avec succès !');
    }
}
?>
