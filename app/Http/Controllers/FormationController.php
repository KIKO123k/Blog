<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(Request $request)
    {
        $majors = Formation::all();
        return view('majors.index', compact('majors'));
    }

    public function show(string $slug)
    {
        $major = Formation::where('slug', $slug)->firstOrFail();
        $userRating = auth()->check() 
            ? $major->ratings()->where('user_id', auth()->id())->first() 
            : null;
            
        return view('majors.show', compact('major', 'userRating'));
    }
}
