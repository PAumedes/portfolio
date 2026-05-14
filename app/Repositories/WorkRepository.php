<?php

namespace App\Repositories;

use App\Models\Work;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class WorkRepository
{
    private const CACHE_KEY = 'portfolio_works';
    private const CACHE_TTL = 3600;

    /**
     * Get all works with media, cached for performance.
     */
    public function getAllActive(): Collection
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function (): Collection {
            return Work::with('media')->latest()->get();
        });
    }

    /**
     * Get paginated works for admin dashboard.
     */
    public function getPaginated(int $perPage = 12): LengthAwarePaginator
    {
        return Work::with('media')->latest()->paginate($perPage);
    }

    /**
     * Find work by slug with media.
     */
    public function findBySlug(string $slug): ?Work
    {
        return Work::where('slug', $slug)->with('media')->first();
    }

    /**
     * Clear the portfolio works cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
