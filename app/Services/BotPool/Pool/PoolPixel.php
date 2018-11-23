<?php

namespace App\Services\BotPool\Pool;

class PoolPixel
{
    private $latitude;
    private $longitude;
    private $space;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->space = 1;
    }
}
