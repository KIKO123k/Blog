<?php

namespace App\Repositories;

use App\Models\Formation;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Collection;

class FormationRepository
{
    public function __construct(
        private CacheService $cache
    ) {}

    /**
     * Get all formations with caching.
     *
     * @return Collection<int, Formation>
     */
    public function all(): Collection
    {
        return $this->cache->remember(
            'formations.all',
            CacheService::TTL_LONG,
            fn () => Formation::all(),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Get formations grouped by category with caching.
     *
     * @return array<string, Collection<int, Formation>>
     */
    public function byCategory(): array
    {
        return $this->cache->remember(
            'formations.by_category',
            CacheService::TTL_LONG,
            fn () => Formation::all()->groupBy('category'),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Find a formation by ID with caching.
     *
     * @param  int  $id
     * @return Formation|null
     */
    public function find(int $id): ?Formation
    {
        return $this->cache->remember(
            "formations.{$id}",
            CacheService::TTL_LONG,
            fn () => Formation::find($id),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_SINGLE]
        );
    }

    /**
     * Find a formation by slug with caching.
     *
     * @param  string  $slug
     * @return Formation|null
     */
    public function findBySlug(string $slug): ?Formation
    {
        return $this->cache->remember(
            "formations.slug.{$slug}",
            CacheService::TTL_LONG,
            fn () => Formation::where('slug', $slug)->first(),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_SINGLE]
        );
    }

    /**
     * Get formations by type with caching.
     *
     * @param  string  $type
     * @return Collection<int, Formation>
     */
    public function byType(string $type): Collection
    {
        return $this->cache->remember(
            "formations.type.{$type}",
            CacheService::TTL_LONG,
            fn () => Formation::where('type', $type)->get(),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Search formations with caching.
     *
     * @param  string  $query
     * @return Collection<int, Formation>
     */
    public function search(string $query): Collection
    {
        $cacheKey = 'formations.search.' . md5($query);

        return $this->cache->remember(
            $cacheKey,
            CacheService::TTL_SHORT,
            fn () => Formation::where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get(),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Create a new formation and invalidate cache.
     *
     * @param  array<string, mixed>  $data
     * @return Formation
     */
    public function create(array $data): Formation
    {
        $formation = Formation::create($data);
        $this->cache->invalidateFormations();
        return $formation;
    }

    /**
     * Update a formation and invalidate cache.
     *
     * @param  Formation  $formation
     * @param  array<string, mixed>  $data
     * @return Formation
     */
    public function update(Formation $formation, array $data): Formation
    {
        $formation->update($data);
        $this->cache->invalidateFormations();
        return $formation->fresh();
    }

    /**
     * Delete a formation and invalidate cache.
     *
     * @param  Formation  $formation
     * @return bool
     */
    public function delete(Formation $formation): bool
    {
        $result = $formation->delete();
        $this->cache->invalidateFormations();
        return $result;
    }

    /**
     * Get recent formations with caching.
     *
     * @param  int  $limit
     * @return Collection<int, Formation>
     */
    public function recent(int $limit = 5): Collection
    {
        return $this->cache->remember(
            "formations.recent.{$limit}",
            CacheService::TTL_MEDIUM,
            fn () => Formation::latest()->limit($limit)->get(),
            [CacheService::TAG_FORMATIONS, CacheService::TAG_LISTS]
        );
    }
}