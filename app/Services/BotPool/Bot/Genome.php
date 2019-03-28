<?php

namespace App\Services\BotPool\Bot;

use App\Services\BotPool\Bot\Commands\CommandInterface;

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
    private const DEFAULT_GENOME_CODE_POSITION = 0;

    /**
     * @var int
     *
     * Позиция в цепочке генома на данный момент
     */
    private $genomeCodePosition;

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
     * @var CommandService
     *
     * Работа с командами бля бота.
     */
    private $commandService;

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
     * @param CommandService $commandService
     * @param array $genomeCode
     *
     * @return void
     */
    public function __construct()
    {
        $this->genomeCodePosition = self::DEFAULT_GENOME_CODE_POSITION;
        $this->genomeCode = $this->createStartGenomeCode();
    }

    /**
     * Мутация генома. Не работает для первой особи
     *
     * @return void
     */
    public function mutate(): void
    {
        if ($this->firstIndividual) {
            return;
        }
        $gen = mt_rand(0, 63);
        $value = mt_rand(0, 63);
        $this->genomeCode[$gen] = $value;
    }
}
