<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Bot\Genome;
use App\Services\BotPool\Bot\Population;
use App\Services\BotPool\Bot\Bot;
use App\Services\BotPool\Pool\Pool;

class Controller
{
    private $population;
    private $genome;
    private $pool;

    public function __construct(Pool $pool)
    {
        dd($pool);
        $this->population = $population;
        $this->genome = $genome;
        $this->pool = $pool;
    }

    private function getFirstBot()              // аля фабричный метод, но нужно будет подумать над реализацией
    {
        $bot = new Bot($this->genome, $this->pool);
        $bot->setCoordinates([0,0]);
        return $bot;
    }

    public function run()
    {
        // создание первого организма
        $this->population->addBot($this->getFirstBot());

        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет
        while ($i++<1000) {
            $this->population->getBots()->each(function (Bot $bot, $key) {
                $bot->runStep();
            });
        }

        // получение снимка состояния(картинка пула с ботами)
        return $this->population->getBots()->dump();
    }
}
