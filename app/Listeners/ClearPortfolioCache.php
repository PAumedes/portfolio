<?php

namespace App\Listeners;

use App\Events\WorkCreated;
use App\Events\WorkDeleted;
use App\Events\WorkUpdated;
use App\Repositories\WorkRepository;

class ClearPortfolioCache
{
    public function __construct(private WorkRepository $repository) {}

    public function handle(WorkCreated|WorkUpdated|WorkDeleted $event): void
    {
        $this->repository->clearCache();
    }
}
