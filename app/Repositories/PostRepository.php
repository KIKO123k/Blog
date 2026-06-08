<?php

namespace App\Repositories;

use App\Models\Post;
use App\Services\CacheService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    public function __construct(
        private CacheService $cache
    ) {}

    /**
     * Get all posts with caching.
     *
     * @return Collection<int, Post>
     */
    public function all(): Collection
    {
        return $this->cache->remember(
            'posts.all',
            CacheService::TTL_MEDIUM,
            fn () => Post::with(['user', 'categories', 'ratings'])->get(),
            [CacheService::TAG_POSTS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Get paginated posts with caching.
     *
     * @param  int  $perPage
     * @return LengthAwarePaginator<Post>
     */
    public function paginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->cache->remember(
            "posts.paginated.{$perPage}",
            CacheService::TTL_MEDIUM,
            fn () => Post::with(['user', 'categories', 'ratings'])
                ->latest()
                ->paginate($perPage),
            [CacheService::TAG_POSTS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Find a post by ID with caching.
     *
     * @param  int  $id
     * @return Post|null
     */
    public function find(int $id): ?Post
    {
        return $this->cache->remember(
            "posts.{$id}",
            CacheService::TTL_LONG,
            fn () => Post::with(['user', 'categories', 'ratings', 'comments.user'])->find($id),
            [CacheService::TAG_POSTS, CacheService::TAG_SINGLE]
        );
    }

    /**
     * Find a post by slug with caching.
     *
     * @param  string  $slug
     * @return Post|null
     */
    public function findBySlug(string $slug): ?Post
    {
        return $this->cache->remember(
            "posts.slug.{$slug}",
            CacheService::TTL_LONG,
            fn () => Post::with(['user', 'categories', 'ratings', 'comments.user'])
                ->where('slug', $slug)
                ->first(),
            [CacheService::TAG_POSTS, CacheService::TAG_SINGLE]
        );
    }

    /**
     * Get posts by category with caching.
     *
     * @param  string  $categorySlug
     * @return Collection<int, Post>
     */
    public function byCategory(string $categorySlug): Collection
    {
        return $this->cache->remember(
            "posts.category.{$categorySlug}",
            CacheService::TTL_MEDIUM,
            fn () => Post::with(['user', 'categories', 'ratings'])
                ->whereHas('categories', fn ($q) => $q->where('slug', $categorySlug))
                ->latest()
                ->get(),
            [CacheService::TAG_POSTS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Get posts by user with caching.
     *
     * @param  int  $userId
     * @return Collection<int, Post>
     */
    public function byUser(int $userId): Collection
    {
        return $this->cache->remember(
            "posts.user.{$userId}",
            CacheService::TTL_MEDIUM,
            fn () => Post::with(['categories', 'ratings'])
                ->where('user_id', $userId)
                ->latest()
                ->get(),
            [CacheService::TAG_POSTS, CacheService::TAG_LISTS]
        );
    }

    /**
     * Create a new post and invalidate cache.
     *
     * @param  array<string, mixed>  $data
     * @return Post
     */
    public function create(array $data): Post
    {
        $post = Post::create($data);
        $this->cache->invalidatePosts();
        return $post;
    }

    /**
     * Update a post and invalidate cache.
     *
     * @param  Post  $post
     * @param  array<string, mixed>  $data
     * @return Post
     */
    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        $this->cache->invalidatePosts();
        return $post->fresh();
    }

    /**
     * Delete a post and invalidate cache.
     *
     * @param  Post  $post
     * @return bool
     */
    public function delete(Post $post): bool
    {
        $result = $post->delete();
        $this->cache->invalidatePosts();
        return $result;
    }

    /**
     * Get recent posts with caching.
     *
     * @param  int  $limit
     * @return Collection<int, Post>
     */
    public function recent(int $limit = 5): Collection
    {
        return $this->cache->remember(
            "posts.recent.{$limit}",
            CacheService::TTL_SHORT,
            fn () => Post::with(['user', 'ratings'])
                ->latest()
                ->limit($limit)
                ->get(),
            [CacheService::TAG_POSTS, CacheService::TAG_LISTS]
        );
    }
}