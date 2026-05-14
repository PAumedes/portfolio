<?php

namespace App\Repositories;

use App\Models\Work;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class WorkRepository
{
    /**
     * Get all active works with media, cached for performance.
     */
    public function getAllActive(): Collection
    {
        return Work::latest()->get();
    }

    /**
     * Clear the portfolio works cache.
     */
    public function clearCache(): void
    {
        Cache::forget('portfolio_works');
    }
}
