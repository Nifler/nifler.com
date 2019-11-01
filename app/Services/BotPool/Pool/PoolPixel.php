<?php

namespace App\Services\BotPool\Pool;

class PoolPixel
{
    public $x;//hight
    public $y;//width

    /**
     * @var integer
     *
     * 0 - пусто
     * 1 - бот
     */
    public $type;

    public function __construct($y, $x)
    {
        $this->y = $y;
        $this->x = $x;
        $this->type = 0;
    }

    public function setItemType(int $type)
    {
        $this->type = $type;
    }
}
