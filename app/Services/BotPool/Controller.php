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
        $data = \Redis::get('PoolSnapshot');

        if (!empty($data)) {
            $data = json_decode($data, true);

            $this->botPopulation->createBots($data['population']);

            $this->pool->setPixels($data['pixels']);
            $this->pool->setRelations($data['itemPixelRelation']);
        } else {
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
        }

        $i = 0;                 // завершение жизни нужно будет переделать, пока что лимит в количество ходов будет

        while ($i++ < 1) {
            foreach ($this->botPopulation->getBots() as $bot) {
                $res = $this->botPopulation->checkStatus($bot);
                $this->pool->registerItem($res);

                if (isset($res['removeItem'])) {
                    continue;
                }
                $this->runBotStep($bot);
            }
        }
        $arr = $this->pool->getArrScrinshot();

        $res = array_merge($arr, ['dimensions' => $this->pool->getDimensions()]);

        \Redis::set('PoolSnapshot', json_encode($res));

        return $res;
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
