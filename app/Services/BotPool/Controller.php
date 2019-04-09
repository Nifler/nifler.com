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
        $id = $this->botPopulation->makeBot();

        $y = 0;
        $x = 2;

        $this->pool->registerItem($id, 1, $y, $x);

        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет

        while ($i++ < 1000) {
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

        $this->commandService->setCommand($commandId);

        $list = $this->commandService->getReuiredInformationList();

        $botInfo = $bot->getBotInfo($list['bot']);
        $poolInfo = $this->pool->getInfo($list['pool'], $bot->id);
        dd(__LINE__, $botInfo, $poolInfo);


        //run command
        //set new ot info
        //bot after processing
            //die
            //clone
            //update population
        //update pool
    }
}
