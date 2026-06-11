<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
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
            'category_label' => $this->category_label,
            'type' => $this->type,
            'description' => $this->description,
            'objectifs' => $this->objectifs ?? [],
            'competences' => $this->competences ?? [],
            'debouches' => $this->debouches ?? [],
            'programme' => $this->programme ?? [],
            'acces' => $this->acces ?? [],
            'partenariats' => $this->partenariats ?? [],
            'source_url' => $this->source_url,
            'duree_annees' => $this->duree_annees,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}