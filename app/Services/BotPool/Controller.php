<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Bot\BotPopulation;
use App\Services\BotPool\Bot\Bot;
use App\Services\BotPool\Command\CommandService;
use App\Services\BotPool\Pool\Pool;

class Controller
{
    private $commandService;
    private $botPopulation;
    private $pool;

    public function __construct(Pool $pool, BotPopulation $botPopulation, CommandService $commandService)
    {
        $this->pool = $pool;
        $this->botPopulation = $botPopulation;
        $this->commandService = $commandService;
    }

    public function run()
    {
        $this->botPopulation->makeBot();

        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет

        while ($i++<1000) {
            foreach ($this->botPopulation->getBots() as $bot) {
                $this->runBotStep($bot);
            }
        }

        // получение снимка состояния(картинка пула с ботами)
        return $this->botPopulation->runBotStep()->dump();
    }

    private function runBotStep(Bot $bot)
    {
        $commandList = $this->commandService->getCommandList();

        $commandId = $bot->getCommandId($commandList);

        dd($commandId);

        //устанавливаем нужную комманду в сервисе по id
        $this->commandService->getReuiredInformationList();
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
