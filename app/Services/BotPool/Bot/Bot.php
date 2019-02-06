<?php

namespace App\Services\BotPool\Bot;

use App\Services\BotPool\Bot\Commands\CommandInterface;
use App\Services\BotPool\Pool\Pool;
use Illuminate\Support\Collection;

/**
 * Class Bot
 *
 * Минимальный организм бассейна. занимает 1 пиксель
 *
 * @package App\Services\BotPool
 */
class Bot
{
    /**
     * @var Pool
     *
     * Вся лужа с данными по каждом пикселе
     */
    private $pool;

    /**
     * @var int
     *
     * Енергия бота на данный момент
     */
    private $energy;

    /**
     * @var int
     *
     * Позиция по оси x
     */
    private $latitude;

    /**
     * @var int
     *
     * Позиция по оси y
     */
    private $longitude;

    /**
     * @var Genome
     *
     * Геном этого бота
     */
    private $genome;

    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * Установка координат организма
     *
     * @param array $coordinates
     */
    public function setCoordinates(array $coordinates): void
    {
        $this->latitude = $coordinates[0];
        $this->longitude = $coordinates[1];
    }

    /**
     * Проверка на мутацию и запуск мутации генома для бота
     *
     * @return void
     */
    private function setGenomeMutation(): void
    {
        if (mt_rand(1, 4) >= 4) {
            $this->genome->mutate();
        }
    }

    /**
     * Проверяет статус бота и либо убивает его, либо нет.(будет рассширятся)
     *
     * @return void
     */
    private function checkBotStatus():void
    {
        if ($this->energy < 0) {
            $this->killBot();
        }
    }

    /**
     * Получаем класс комманды бота на этом ходу согласно геному
     *
     * @return string
     */
    private function initCommand()
    {
        $this->command = $this->genome->getCommand();
    }

    /**
     * Убиваем бота
     *
     */
    private function killBot(): void
    {
        // kill this bot
    }

    private function getBotInfo()                   //BotInfo должен быть доп класом а не колекцией(позже переделать)
    {
        return collect([
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'energy' => $this->energy
        ]);
    }

    private function setBotInfo(Collection $botInfo)
    {
        $botInfo->each(function ($item, $key) {
            $this->$key = $item;
        });
    }

    /**
     * Bot constructor.
     *
     * @param Genome $genome
     * @param Pool $pool
     *
     */
    public function __construct(Genome $genome, Pool $pool)
    {
        $this->energy = 0;
        $this->genome = $genome;
        $this->pool = $pool;
        $this->setGenomeMutation();
    }

    /**
     * Новый ход бота
     */
    public function runStep()
    {
        $this->pool->getPixel($this->latitude, $this->longitude);
        $this->checkBotStatus();
        $this->initCommand();
        $updatedBotInfo = $this->command->run($this->getBotInfo());
        $this->setBotInfo($updatedBotInfo);

        $this->checkBotStatus();
        // конец
    }
}
