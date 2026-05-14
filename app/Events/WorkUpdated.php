<?php

namespace App\Events;

use App\Models\Work;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Work $work) {}
}
