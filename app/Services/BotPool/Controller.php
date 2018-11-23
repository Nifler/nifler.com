<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Bot\Population;
use App\Services\BotPool\Bot\Bot;

class Controller
{
    private $population;
    private $bot;

    public function __construct(Population $population, Bot $bot)
    {
        $this->population = $population;
        $this->bot = $bot;
    }

    private function getFirstBot()              // аля фабричный метод, но нужно будет подумать над реализацией
    {
        $this->bot->setCoordinates([1,1]);
        return $this->bot;
    }

    public function run()
    {
        // создание первого организма
        $this->population->addBot($this->getFirstBot());

        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет
        while ($i++<1000) {
            $this->population->getBots()->each(function ($bot, $key) {
                $bot->runStep();
            });
        }

        // получение снимка состояния(картинка пула с ботами)
        $this->population->getBots()->dump();
    }
}
