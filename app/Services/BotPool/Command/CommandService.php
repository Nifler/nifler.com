<?php

namespace App\Services\BotPool\Command;

use App\Services\BotPool\Bot\Commands\CommandInterface;
use App\Services\BotPool\Bot\Commands\Move;
use App\Services\BotPool\Bot\Commands\Photosynthesis;

class CommandService
{
    // соответствие ид генома к комманде. это безобразие переделать через конфиг
    const COMMANDS = [
        1 => Move::class,
        2 => Photosynthesis::class
    ];

    private $commandId;
    private $commandInfo;
    private $command;

    /**
     * Проверка наличия комманды для ид
     *
     * @param int $id
     *
     * @return bool
     */
    private function checkCommand(int $id): bool
    {

    }

    /**
     * Установка комманды для бота
     *
     * @param int $id
     *
     * @return bool
     */
    public function setCommand(int $id): bool
    {
    }

    /**
     * Возвращает комманду
     *
     * @return string
     */
    public function getCommand(): CommandInterface
    {
        return $this->command;
    }


    public function getReuiredInformationList()
    {
        return $this->command;
    }

    public function getCommandList(): array
    {
        return self::COMMANDS;
    }
}
