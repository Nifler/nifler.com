<?php

namespace App\Services\BotPool;

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
     * @var int
     *
     * Енергия бота на данный момент
     */
    private $energi;

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
     * Установка координат организма
     *
     * @param int $latitude
     * @param int $longitude
     */
    private function setCoordinates(int $latitude, int $longitude):void
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Проверка на мутацию и запуск мутации генома для бота
     *
     * @return void
     */
    private function setGenomeMutation(): void
    {
        if (mt_rand(1,4) >= 4) {
            $this->genome->mutate();
        }
    }

    private function checkBotStatus()
    {
        //проверка енергии
    }

    private function getCommand()
    {
        $this->genome->getCommandId();
    }

    /**
     * Bot constructor.
     *
     * @param Genome $genome
     * @param int $latitude
     * @param int $longitude
     */
    public function __construct(Genome $genome, $latitude = 0, $longitude = 0)
    {
        $this->energi = 0;
        $this->setCoordinates($latitude, $longitude);
        $this->genome = $genome;
        $this->setGenomeMutation();
    }

    public function runStep()
    {
        $this->checkBotStatus();
        $this->getCommand();
        // выполнение команды
        $this->checkBotStatus();
        // конец
    }
}