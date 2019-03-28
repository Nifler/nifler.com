<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Bot\BotPopulation;
use App\Services\BotPool\Bot\Bot;
use App\Services\BotPool\Pool\Pool;

class Controller
{
    private $botPopulation;
    private $pool;

    public function __construct(Pool $pool, BotPopulation $botPopulation)
    {
        $this->botPopulation = $botPopulation;
        $this->pool = $pool;
    }

    public function run()
    {
        $this->botPopulation->makeBot();

        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет

        while ($i++<1000) {
            foreach ($this->botPopulation->getBots() as $bot) {
                $this->runStep($bot);
            }
        }

        // получение снимка состояния(картинка пула с ботами)
        return $this->botPopulation->runBotStep()->dump();
    }

    private function runBotStep(Bot $bot)
    {
        //get command id
        //get list of required for command info
        //get info from bot
        //get info from poll
        //run command
        //set new ot info
        //bot after processing
            //die
            //clone
            //update population
        //update pool
    }
}
