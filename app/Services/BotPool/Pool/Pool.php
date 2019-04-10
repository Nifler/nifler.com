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
            'itemId' => 0,
        ]
    ];

    /**
     * @var array
     */
    private $poolPixels;

    private $width;

    private $height;

    private $botPopulation;

    /**
     * @var array
     * itemId->pixelId
     */
    private $itemPixelRelation;

    public function __construct(BotPopulation $botPopulation)
    {
        $this->botPopulation = $botPopulation;
        $this->width = config('botPool.pool.width');
        $this->height = config('botPool.pool.height');
        $this->fillPixels();
    }

    private function fillPixels()
    {
        $poolPoints = [];
        for ($y = 0; $y < $this->width; $y++) {
            for ($x = 0; $x < $this->height; $x++) {
                $poolPoints[] = new PoolPixel($y, $x);
            }
        }
        $this->poolPixels = $poolPoints;
    }

    public function getPixelId($y, $x)
    {
        return $y * $this->width + $x;
    }

    public function getInfo($list, $botId): array
    {
        $res = [];
        foreach ($list as $key => $value) {
            switch ($key) {
                case 'area' :
                    $pixel = $this->getPixelByItemId($botId);
                    $res['area'] = $this->getBotArea($value, $pixel);
            }
        }
        return $res;
    }

    private function getPixelByItemId($itemId)
    {
        $pixelId = $this->itemPixelRelation[$itemId];

        return $this->poolPixels[$pixelId];
    }

    private function getBotArea($radius, $pixel): array
    {
        $area = [];

        for ($y = -$radius; $y <= $radius; $y++) {
            for ($x = -$radius; $x <= $radius; $x++) {
                if(!isset($area[$y])) {
                    $area[$y] = [];
                }
                if ($pixel->y + $y < 0 || $pixel->y + $y > $this->height) {
                    $area[$y][$x] = -1;
                    continue;
                }
                $pixelY = $pixel->y + $y;

                if ($pixel->x + $x < 0) {
                    $pixelX = $pixel->x + $x + $this->width;
                } elseif ($pixel->x + $x > $this->width) {
                    $pixelX = $pixel->x + $x - $this->width;
                } else {
                    $pixelX = $pixel->x + $x;
                }

                $foundPixelId = $this->getPixelId($pixelY, $pixelX);
                $area[$y][$x] = $this->poolPixels[$foundPixelId]->type ?? 0;
            }
        }

        return $area;
    }

    public function registerItem($itemId, $type, $y, $x)
    {
        $pixelId = $this->getPixelId($y, $x);
        $this->itemPixelRelation[$itemId] = $pixelId;

        $this->poolPixels[$pixelId]->setItemType($type);
    }

    public function changeInfo($properties, $botId)
    {
        $pixel = $this->getPixelByItemId($botId);
        foreach ($properties as $property => $value) {
            switch ($property) {
                case 'coordinateChange':
                    $this->moveItem($pixel, $value, $botId);
                    break;
            }
        }
        return true;
    }

    private function moveItem($currentPixel, $direction, $botId)
    {
        if (empty(array_diff($direction, [0,0]))) {
            return true;
        }

        $currentPixel->type = 0;
        $this->save($currentPixel);

        $newY = $currentPixel->y + $direction['y'];
        $newX = ($currentPixel->x + $direction['x']) % $this->width;

        $newPixelId = $this->getPixelId($newY, $newX);
        $this->poolPixels[$newPixelId]->type = 1;

        $this->itemPixelRelation[$botId] = $newPixelId;

        return true;
    }

    private function save(PoolPixel $pixel)
    {
        $id = $this->getPixelId($pixel->y, $pixel->x);
        $this->poolPixels[$id] = $pixel;
    }
}
