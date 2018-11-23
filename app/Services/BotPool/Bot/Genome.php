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
     * Присвоение генома для нового бота
     *
     * @param $genomeCode
     */
    public function setGenomeCode($genomeCode): void
    {
        if (empty($genomeCode)) {
            $this->genomeCode = $this->createStartGenomeCode();
            return;
        }
        $this->genomeCode = $genomeCode;
        $this->firstIndividual = true;
    }

    /**
     * Genome constructor.
     *
     * @param CommandService $commandService
     * @param array $genomeCode
     *
     * @return void
     */
    public function __construct(CommandService $commandService)
    {
        $this->genomeCodePosition = self::DEFAULT_GENOME_CODE_POSITION;
        $this->commandService = $commandService;
        $this->setGenomeCode([]);//здесь при наследовании нужно переливать геном
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

    /**
     * Получаем класс комманды для исполнения
     *
     * @return CommandInterface
     */
    public function getCommand():CommandInterface
    {
        // ищем id команды
        $commandId = $this->genomeCode[$this->genomeCodePosition];

        $i = 0;
        while (!$this->commandService->setCommandId($commandId)) {
            $i++;
            $this->genomeCodePosition = ($this->genomeCodePosition + $commandId) % self::MAX_LENGTH;
            if ($i>15) {
                dd('нету команды для бота после 15 итераций поиска');
                // нету команды. придумать что делать с таким неудачником
            }
        }

        //изучаем комманду
        $commandInfo = $this->commandService->getCommandInfo();

        // получение команды по id
        $command = $this->commandService->getCommand();

        // получение параметров с генома(если нужно)
        // возвращаем (int)id (array)params
        return $command;
    }
}
