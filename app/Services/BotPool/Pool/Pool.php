<?php

namespace App\Services\BotPool\Pool;

use Illuminate\Support\Collection;

class Pool
{
    private $poolPixels;

    public function __construct(Collection $poolPixels)
    {
        $this->poolPixels = $poolPixels;
    }
}
