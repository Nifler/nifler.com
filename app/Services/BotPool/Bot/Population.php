<?php

namespace App\Services\BotPool\Bot;

use Illuminate\Support\Collection;

/**
 * Class Population
 *
 * Коллекция всех существующих ботов на данный момент.
 *
 * @package App\Services\BotPool\Bot
 */
class Population
{
    /**
     * @var Collection
     */
    private $botCollection;

    public function __construct()
    {
        $this->botCollection = collect();
    }

    public function addBot(Bot $bot)
    {
        $this->botCollection->push($bot);
    }

    public function getBots()
    {
        return $this->botCollection;
    }
}
