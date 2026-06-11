<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MajorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'short_desc' => $this->shortDesc,
            'description' => $this->description,
            'duration' => $this->duration,
            'admission_criteria' => $this->admission_criteria,
            'careers' => $this->careers ?? [],
            'modules' => $this->modules ?? [],
            'objectifs' => $this->objectifs ?? [],
            'competences' => $this->competences ?? [],
            'debouches' => $this->debouches ?? [],
            'acces' => $this->acces ?? [],
            'partenariats' => $this->partenariats ?? [],
            'source_url' => $this->source_url,
            'video_path' => $this->video_path,
            'average_rating' => $this->average_rating,
            'ratings_count' => $this->ratings()->count(),
            'comments_count' => $this->comments()->count(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}