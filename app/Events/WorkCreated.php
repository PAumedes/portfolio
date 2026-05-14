<?php

namespace App\Events;

use App\Models\Work;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Dispatched when a new work item is created.
 *
 * Triggers cache invalidation so portfolio displays updated works.
 */
class WorkCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Work $work) {}
}
