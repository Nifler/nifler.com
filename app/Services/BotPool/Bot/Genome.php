<?php

namespace App\Services\BotPool\Bot;

/**
 * Class Genome
 *
 * Геном для бота. Определяет действия бота во время следующего хода.
 *
 * @package App\Services\BotPool
 */
class Genome
{
    /**
     * Длина цепочки генома(количество ячеек для действий)
     */
    private const MAX_LENGTH = 64;

    /**
     * Default command
     */
    private const DEFAULT_COMMAND_ID = 2;

    /**
     * Начальная позиция в цепочке генома
     */
    private const DEFAULT_GENOME_CODE_POSITION = 0;

    /**
     * @var int
     *
     * Позиция в цепочке генома на данный момент
     */
    public $genomeCodePosition;

    /**
     * @var
     *
     * Цепочка с кодом генома
     */
    public $genomeCode;

    /**
     * Создание генома для бота без родительского генома
     *
     * @return array
     */
    private function createStartGenomeCode(): array
    {
        $genomeCode = [];
        for ($i = 0; $i < self::MAX_LENGTH; $i++) {
            $genomeCode[$i] = 1;
        }
        return $genomeCode;
    }

    /**
     * Genome constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->genomeCodePosition = self::DEFAULT_GENOME_CODE_POSITION;
        $this->genomeCode = $this->createStartGenomeCode();
    }

    /**
     * @return void
     */
    public function mutate(): void
    {
        $gen = mt_rand(0, 63);
        $value = mt_rand(0, 63);
        $this->genomeCode[$gen] = $value;
    }

    /**
     * Get existed command id
     *
     * @param array $idList
     *
     * @return int
     */
    public function getCommandId(array $idList): int
    {
        for($i=1; $i<=15; $i++){
            if( in_array($this->genomeCode[$this->genomeCodePosition], $idList) ) {
                return $this->genomeCode[$this->genomeCodePosition];
            }
            $this->moveGenomeCodePosition();
        }
        return self::DEFAULT_COMMAND_ID;
    }

    /**
     * Moving genome code position along genome
     */
    private function moveGenomeCodePosition()
    {
        $res = $this->genomeCodePosition + $this->genomeCode[$this->genomeCodePosition];

        $this->genomeCodePosition = $res % self::MAX_LENGTH;
    }
}
