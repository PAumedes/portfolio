<?php

namespace App\Providers;

use App\Events\WorkCreated;
use App\Events\WorkDeleted;
use App\Events\WorkUpdated;
use App\Listeners\ClearPortfolioCache;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        WorkCreated::class => [ClearPortfolioCache::class],
        WorkUpdated::class => [ClearPortfolioCache::class],
        WorkDeleted::class => [ClearPortfolioCache::class],
    ];
}
