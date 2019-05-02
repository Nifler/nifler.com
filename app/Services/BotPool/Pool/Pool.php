<?php

namespace App\Services\BotPool\Pool;

use App\Services\BotPool\Bot\BotPopulation;
use Illuminate\Support\Collection;
use mysql_xdevapi\Exception;

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
                case 'area':
                    $pixel = $this->getPixelByItemId($botId);
                    $res['area'] = $this->getBotArea($value, $pixel);
                    break;
                case 'y':
                    $res['y'] = $this->getPixelByItemId($botId)->y;
                    break;
            }
        }
        return $res;
    }

    private function getPixelByItemId($itemId): PoolPixel
    {
        if(!isset($this->itemPixelRelation[$itemId])) {
            throw new \Exception('For this item is no relation');
        }
        $pixelId = $this->itemPixelRelation[$itemId];

        return $this->poolPixels[$pixelId];
    }

    private function getBotArea($radius, $pixel): array
    {
        $area = [];

        for ($y = -$radius; $y <= $radius; $y++) {
            for ($x = -$radius; $x <= $radius; $x++) {
                if (!isset($area[$y])) {
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

    private function removeItem($itemId)
    {
        $pixel = $this->getPixelByItemId($itemId);
        $pixel->setItemType(0);
        unset($this->itemPixelRelation[$itemId]);
        return [
            'status' => true,
            'id' => $itemId
        ];
    }

    private function getCoordinateDirection(int $dir): array
    {
        switch ($dir) {
            case 0:
                return [
                    'y' => -1,
                    'x' => 0
                ];
            case 1:
                return [
                    'y' => -1,
                    'x' => 1
                ];
            case 2:
                return [
                    'y' => 0,
                    'x' => 1
                ];
            case 3:
                return [
                    'y' => 1,
                    'x' => 1
                ];
            case 4:
                return [
                    'y' => 1,
                    'x' => 0
                ];
            case 5:
                return [
                    'y' => 1,
                    'x' => -1
                ];
            case 6:
                return [
                    'y' => 0,
                    'x' => -1
                ];
            case 7:
                return [
                    'y' => -1,
                    'x' => -1
                ];
            default:
                return [];
        }
    }

    private function getCoordinateForChild(int $parent)
    {
        $direction = rand(0, 7);
        $pixel = $this->getPixelByItemId($parent);

        for ($i = 0; $i < 8; $i++) {
            $dirYX = $this->getCoordinateDirection(($direction + $i) % 8);
            $coordinates = [
                'y' => $pixel->y + $dirYX['y'],
                'x' => ($pixel->x + $dirYX['x'] + $this->width) % $this->width
            ];

            if ($this->checkEmptyPixelByCoordinates($coordinates)) {
                return $coordinates;
            }
        }

        return[];
    }

    private function checkEmptyPixelByCoordinates(array $coordinates)
    {
        if ($coordinates['y'] < 0 || $coordinates['y'] > $this->width) {
            return false;
        }
        $pixelId = $this->getPixelId($coordinates['y'], $coordinates['x']);

        if (!isset($this->poolPixels[$pixelId])) {
            throw new \Exception("Pixel $pixelId is not exist.");
        }

        return $this->poolPixels[$pixelId]->type === 0;
    }

    /**
     * @param array $info
     *
     * @return array
     *
     * @throws \Exception
     */
    private function addItem(array $info)
    {
        if (isset($info['coordinates'])) {
            if (!$this->checkEmptyPixelByCoordinates($info['coordinates'])) {
                throw new \Exception('Pixel is not free');
            }
            $coordinates = $info['coordinates'];
        } elseif (isset($info['parent'])) {
            $coordinates = $this->getCoordinateForChild($info['parent']);
            if (empty($coordinates)) {
                return[
                    'remove' => $info['parent']
                ];
            }
        } else {
            throw new \Exception('Bad data for creating');
        }

        $pixelId = $this->getPixelId($coordinates['y'], $coordinates['x']);
        $this->itemPixelRelation[$info['child']] = $pixelId;
        $this->poolPixels[$pixelId]->setItemType(1);
        return [
            'added' => $info['child']
        ];
    }

    public function registerItem($item)
    {
        $result = [];
        foreach ($item as $key => $value) {
            switch ($key) {
                case 'addItem':
                    $res = $this->addItem($value);
                    $result[] = [
                        'action' => 'add',
                        'id' => $res['added']
                    ];
                    break;
                case 'removeItem':
                    $this->removeItem($value);
                    $result[] = [
                        'action' => 'remove',
                        'id' => $value
                    ];
                    break;
            }
        }
        return $result;
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

    private function getPoolPixelsArr(): array
    {
        $arr=[];
        foreach ($this->poolPixels as $key => $value) {
            $arr[$key]['type'] = $value->type;
        }

        return $arr;
    }

    private function getBotPopulationArr()
    {
        $arr = [];
        foreach ($this->botPopulation->getBots() as $key => $bot)
        {
            $arr[$key]['properties'] = $bot->getProperties();
            $arr[$key]['genome'] = $bot->getGenome();
        }

        return $arr;
    }

    public function getArrScrinshot()
    {
        $this->getPoolPixelsArr();

        $this->getBotPopulationArr();

        $this->itemPixelRelation;

        return [
            'pixels' => $this->getPoolPixelsArr(),
            'population' => $this->getBotPopulationArr(),
            'itemPixelRelation' => $this->itemPixelRelation
        ];
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
