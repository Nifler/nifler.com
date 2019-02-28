<?php

namespace App\Services\BotPool\Pool;

use Illuminate\Support\Collection;

class Pool
{
    /**
     * @var Collection
     */
    private $poolPixels;

    private $width;

    private $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->fillPixels();
    }

    private function fillPixels()
    {
        $poolPoints = [];
        for ($i=0; $i <= $this->width; $i++) {
            for ($j=0; $j <= $this->height; $j++) {
                $poolPoints[] = new PoolPixel($i, $j);
            }
        }
        $this->poolPixels = collect($poolPoints);
    }

    public function getPixel($latitude, $longitude)
    {
        $key = $latitude*$this->width + $longitude;

        return $this->poolPixels[$key];
    }
}
