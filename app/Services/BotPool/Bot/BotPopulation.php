<?php

namespace App\Services\BotPool\Bot;

/**
 * Class Population
 *
 * Коллекция всех существующих ботов на данный момент.
 *
 * @package App\Services\BotPool\Bot
 */
class BotPopulation
{
    /**
     * @var array
     */
    private $botPopulation;

    public function __construct()
    {
        $this->botPopulation = [];
    }

    public function addBot(Bot $bot): int
    {
        $this->botPopulation[] = $bot;
        return array_key_last($this->botPopulation);
    }

    public function getBots(): array
    {
        return $this->botPopulation;
    }

    public function makeBot(): int
    {
        $bot = new Bot();
        $botId = $this->addBot($bot);

        return $botId;
    }

    public function checkStatus(Bot $bot)
    {
        $list = [
            'energy' => true
        ];

        $info = $bot->getBotInfo($list);

        if ($info['energy'] <= 0) {
            $id = $this->kill($bot);
            return [
                'removeItem' => $id
            ];
        }

        if ($info['energy'] >=1000) {
            $ids = $this->reproduction($bot);
            return [
                'addItem' => $ids
            ];
        }

        return [
            'result' => true
        ];
    }

    /**
     * На данный момент смерть это просто удаление бота с пула и популяции
     *
     * @param Bot $bot
     *
     * @return int
     */
    private function kill(Bot $bot)
    {
        unset($this->botPopulation[$bot->id]);
        return $bot->id;
    }

    private function reproduction(Bot $bot)
    {
        $bot->changeInfo([
            'energy' => 10
        ]);

        $childBot = clone $bot;

        $this->botPopulation[] = $childBot;

        $childBot->id = array_key_last($this->botPopulation);

        return [
            'parent' => $bot->id,
            'child' => $childBot->id
        ];
    }
}
