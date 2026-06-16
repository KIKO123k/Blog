<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MajorVideoController extends Controller
{
    public function upload(Request $request, $id)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Seuls les administrateurs peuvent télécharger des vidéos.');
        }

        $major = Major::findOrFail($id);

        $request->validate([
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:50000', // 50MB max
        ]);

        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($major->video_path) {
                Storage::disk('public')->delete($major->video_path);
            }

            $path = $request->file('video')->store('majors/videos', 'public');
            $major->update(['video_path' => $path]);

            return back()->with('success', 'La vidéo a été téléchargée avec succès !');
        }

        return back()->with('error', 'Erreur lors du téléchargement de la vidéo.');
    }
}
