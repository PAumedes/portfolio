<?php

namespace App\Listeners;

use App\Events\WorkCreated;
use App\Events\WorkDeleted;
use App\Events\WorkUpdated;
use App\Repositories\WorkRepository;

/**
 * Clear portfolio cache when work items change.
 *
 * Ensures cached portfolio data stays in sync when works are created, updated, or deleted.
 * Single source of truth for cache invalidation strategy.
 */
class ClearPortfolioCache
{
    public function __construct(private WorkRepository $repository) {}

    /**
     * Handle work creation, update, or deletion events.
     *
     * @param WorkCreated|WorkUpdated|WorkDeleted $event
     */
    public function handle(WorkCreated|WorkUpdated|WorkDeleted $event): void
    {
        $this->repository->clearCache();
    }
}
