<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class CacheService
{
    /**
     * Cache TTL values in seconds.
     */
    public const TTL_SHORT = 300;      // 5 minutes
    public const TTL_MEDIUM = 3600;   // 1 hour
    public const TTL_LONG = 86400;     // 24 hours

    /**
     * Cache tag prefixes.
     */
    public const TAG_POSTS = 'posts';
    public const TAG_FORMATIONS = 'formations';
    public const TAG_LISTS = 'lists';
    public const TAG_SINGLE = 'single';

    /**
     * Get a cached value or execute the callback and cache the result.
     *
     * @param  string  $key
     * @param  int  $ttl  Time-to-live in seconds
     * @param  callable  $callback
     * @param  array  $tags
     * @return mixed
     */
    public function remember(string $key, int $ttl, callable $callback, array $tags = [])
    {
        return Cache::tags($tags)->remember($key, $ttl, $callback);
    }

    /**
     * Get a cached value or return null if not found.
     *
     * @param  string  $key
     * @param  array  $tags
     * @return mixed
     */
    public function get(string $key, array $tags = [])
    {
        return Cache::tags($tags)->get($key);
    }

    /**
     * Store a value in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $ttl
     * @param  array  $tags
     * @return void
     */
    public function put(string $key, $value, int $ttl, array $tags = []): void
    {
        Cache::tags($tags)->put($key, $value, $ttl);
    }

    /**
     * Remove a value from the cache.
     *
     * @param  string  $key
     * @param  array  $tags
     * @return void
     */
    public function forget(string $key, array $tags = []): void
    {
        Cache::tags($tags)->forget($key);
    }

    /**
     * Flush all cache entries with the given tags.
     *
     * @param  array  $tags
     * @return void
     */
    public function flush(array $tags): void
    {
        Cache::tags($tags)->flush();
    }

    /**
     * Invalidate all posts cache.
     *
     * @return void
     */
    public function invalidatePosts(): void
    {
        Cache::tags([self::TAG_POSTS, self::TAG_LISTS, self::TAG_SINGLE])->flush();
    }

    /**
     * Invalidate all formations cache.
     *
     * @return void
     */
    public function invalidateFormations(): void
    {
        Cache::tags([self::TAG_FORMATIONS, self::TAG_LISTS, self::TAG_SINGLE])->flush();
    }

    /**
     * Check if a key exists in cache.
     *
     * @param  string  $key
     * @param  array  $tags
     * @return bool
     */
    public function has(string $key, array $tags = []): bool
    {
        return Cache::tags($tags)->has($key);
    }
}