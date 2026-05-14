<?php

namespace App\Events;

use App\Models\Work;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Dispatched when a work item is deleted.
 *
 * Triggers cache invalidation so portfolio no longer displays deleted work.
 */
class WorkDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(public Work $work) {}
}
