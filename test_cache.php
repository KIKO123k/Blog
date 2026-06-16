<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;
use App\Repositories\PostRepository;
use App\Repositories\FormationRepository;

echo "=== Redis Cache Test ===\n\n";

// Test 1: Basic cache write/read
Cache::put('test_key', 'test_value', 60);
$val = Cache::get('test_key');
echo "1. Basic cache write/read: " . ($val === 'test_value' ? 'PASS' : 'FAIL (' . $val . ')') . "\n";

// Test 2: Cache::has
echo "2. Cache::has check: " . (Cache::has('test_key') ? 'PASS' : 'FAIL') . "\n";

// Test 3: Cache::forget
Cache::forget('test_key');
echo "3. Cache forget: " . (!Cache::has('test_key') ? 'PASS' : 'FAIL') . "\n";

// Test 4: CacheService
$cacheService = app(CacheService::class);
$result = $cacheService->remember('service_test', 60, fn() => 'cached_value', ['test_tag']);
echo "4. CacheService remember: " . ($result === 'cached_value' ? 'PASS' : 'FAIL') . "\n";

// Test 5: Cache tags
$tagged = Cache::tags(['posts', 'lists']);
$tagged->put('tagged_key', 'tagged_value', 60);
$taggedValue = $tagged->get('tagged_key');
echo "5. Cache tags: " . ($taggedValue === 'tagged_value' ? 'PASS' : 'FAIL') . "\n";

// Test 6: PostRepository instantiation
$postRepo = app(PostRepository::class);
echo "6. PostRepository instantiated: " . ($postRepo instanceof PostRepository ? 'PASS' : 'FAIL') . "\n";

// Test 7: FormationRepository instantiation
$formationRepo = app(FormationRepository::class);
echo "7. FormationRepository instantiated: " . ($formationRepo instanceof FormationRepository ? 'PASS' : 'FAIL') . "\n";

// Test 8: Check config
echo "8. Cache driver config: " . (config('cache.default') === 'redis' ? 'PASS (redis)' : 'FAIL (' . config('cache.default') . ')') . "\n";
echo "9. Redis client config: " . (config('database.redis.client') === 'predis' ? 'PASS (predis)' : 'FAIL (' . config('database.redis.client') . ')') . "\n";

echo "\n=== All Tests Complete ===\n";