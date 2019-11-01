<?php

namespace App\Services\BotPool\Bot;

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
    private $energy;

    /**
     * @var Genome
     *
     * Геном этого бота
     */
    private $genome;

    /**
     * @var integer
     */
    public $id;

    /**
     * Bot constructor.
     */
    public function __construct()
    {
        $this->genome = new Genome();
        $this->energy = 10;
        $this->id = 0;
    }

    public function setProperties($properties)
    {
        $this->id = $properties['id'];
        $this->energy = $properties['energy'];
    }

    public function setGenome($genome)
    {
        $this->genome->genomeCode = $genome['code'];
        $this->genome->genomeCodePosition = $genome['position'];
    }

    public function __clone()
    {
        $this->genome = clone $this->genome;
    }

    public function getProperties()
    {
        return [
            'id' => $this->id,
            'energy' => $this->energy
        ];
    }

    public function getGenome()
    {
        return [
            'position' => $this->genome->genomeCodePosition,
            'code' => $this->genome->genomeCode
        ];
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
     * Отдаем данные, которые запросили при помощи $list
     *
     * @param $list
     *
     * @return array
     */
    public function getBotInfo($list): array
    {
        $info = [];
        foreach ($list as $item => $option) {
            switch ($item) {
                case 'genome':
                    $info['genome'] = $this->genome->genomeCode;
                    break;
                case 'commandId':
                    $info['commandId'] = $this->genome->genomeCodePosition;
                    break;
                case 'energy':
                    $info['energy'] = $this->energy;
                    break;
            }
        }

        return $info;
    }

    public function changeInfo(array $properties)
    {
        foreach ($properties as $property => $value) {
            switch ($property) {
                case 'energyChange':
                    $this->energy += $value;
                    break;
                case 'energy':
                    $this->energy = $value;
                    break;
            }
        }
    }
}
