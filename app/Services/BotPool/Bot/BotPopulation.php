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
}
