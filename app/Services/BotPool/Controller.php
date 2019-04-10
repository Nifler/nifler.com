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

        while ($i++ < 7) {
            foreach ($this->botPopulation->getBots() as $bot) {
                //проверяем состояние бота(смерть размножение)
                $this->runBotStep($bot);
            }
        }
        dd($this->pool);
    }

    private function runBotStep(Bot $bot)
    {
        $commandList = $this->commandService->getCommandList();

        $commandId = $bot->getCommandId($commandList);

        $this->commandService->setCommand($commandId);

        $list = $this->commandService->getReuiredInformationList();

        $botInfo = $bot->getBotInfo($list['bot']);
        $poolInfo = $this->pool->getInfo($list['pool'], $bot->id);

        $result = $this->commandService->runCommand($botInfo, $poolInfo);

        $bot->changeInfo($result['bot']);
        $this->pool->changeInfo($result['pool'], $bot->id);
    }
}
