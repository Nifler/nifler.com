<?php

namespace App\Services\BotPool\Pool;

use App\Services\BotPool\Bot\BotPopulation;
use Illuminate\Support\Collection;

class Pool
{
    /**
     * @var array
     *
     * Карта пула. Пока что будет только один тип итемов - Bot. Далее есть возможность расширения.
     */
    private $map = [
        'pixelId' => [
            'itemType' => 0,
            'itemId' => 0
        ]
    ];

    /**
     * @var Collection
     */
    private $poolPixels;

    private $width;

    private $height;

    private $population;

    public function __construct()
    {
        $this->width = config('botPool.pool.width');
        $this->height = config('botPool.pool.height');
        $this->fillPixels();
    }

    private function fillPixels()
    {
        $poolPoints = [];
        for ($i=0; $i < $this->width; $i++) {
            for ($j=0; $j < $this->height; $j++) {
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
