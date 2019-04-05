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
     * @param array $commandList
     *
     * @return integer
     */
    public function getCommandId(array $commandList): int
    {
        $idList = array_keys($commandList);

        return $this->genome->getCommandId($idList);
    }

    /**
     * Убиваем бота
     *
     */
    private function killBot(): void
    {
        // kill this bot
    }

    public function getBotInfo($list)
    {
        $info = [];
        foreach ($list as $item => $option)
            switch ($item) {
                case 'genom' :
                    $info['genom'] = $this->genome->genomeCode;
                    break;
                case 'commandId' :
                    $info['commandId'] = $this->genome->genomeCodePosition;
                    break;
            }
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
    public function __construct()
    {
        $this->genome = new Genome();
        $this->energy = 0;
    }
}
