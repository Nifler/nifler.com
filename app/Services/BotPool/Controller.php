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

        $item = [
            'addItem' => [
                'parent' => false,
                'child' => $id,
                'coordinates' => [
                    'y' => 1,
                    'x' => 1
                ]
            ]
        ];

        $this->pool->registerItem($item);



        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет


        while ($i++ < 11) {
            foreach ($this->botPopulation->getBots() as $bot) {
                $res = $this->botPopulation->checkStatus($bot);
                $this->pool->registerItem($res);

                if (isset($res['removeItem'])) {
                    continue;
                }

                $this->runBotStep($bot);
            }
        }
        dd($this->pool, $this->botPopulation);
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

//        if ($bot->id) var_dump($result['bot'], $bot->getBotInfo(['energy' => true]));

        $bot->changeInfo($result['bot']);

        $this->pool->changeInfo($result['pool'], $bot->id);
    }
}
