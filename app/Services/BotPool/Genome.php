<?php

namespace App\Services\BotPool;

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
     * Начальная позиция в цепочке генома
     */
    private const DEFAULT_POSITION = 0;

    /**
     * @var int
     *
     * Позиция в цепочке генома на данный момент
     */
    private $position;

    /**
     * @var
     *
     * Цепочка с кодом генома
     */
    private $genomeCode;

    /**
     * @var bool
     *
     * Первая особь в виде(первая особь в мире)
     */
    private $firstIndividual = false;

    /**
     * Создание генома для бота без родительского генома
     *
     * @return array
     */
    private function createStartGenomeCode(): array
    {
        $genomeCode = [];
        for($i = 0; $i < self::MAX_LENGTH; $i++) {
            $genomeCode[$i] = 1;
        }
        return $genomeCode;
    }

    /**
     * Присвоение генома для нового бота
     *
     * @param $genomeCode
     */
    private function setGenomeCode($genomeCode): void
    {
        if(empty($genomeCode)){
            $this->genomeCode = $this->createStartGenomeCode();
            return;
        }
        $this->genomeCode = $genomeCode;
        $this->firstIndividual = true;
    }

    /**
     * Genome constructor.
     * @param array $genomeCode
     */
    public function __construct($genomeCode = [])
    {
        $this->position = self::DEFAULT_POSITION;
        $this->setGenomeCode($genomeCode);
    }

    /**
     * Мутация генома. Не работает для первой особи
     *
     * @return void
     */
    public function mutate(): void
    {
        if($this->firstIndividual) {
            return;
        }
        $gen = mt_rand(0,63);
        $value = mt_rand(0,63);
        $this->genomeCode[$gen] = $value;
    }

    public function getCommandId()
    {
        // ищем id
        // проверяем существование комманды
        // промотка на след место в геноме если нет комманды
        // получение параметров с генома(если нужно)
        // возвращаем (int)id (array)params
    }
}