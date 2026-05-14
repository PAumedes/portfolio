<?php

namespace App\Events;

use App\Models\Work;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Dispatched when a work item is updated.
 *
 * Triggers cache invalidation so portfolio displays updated work information.
 */
class WorkUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Work $work) {}
}
