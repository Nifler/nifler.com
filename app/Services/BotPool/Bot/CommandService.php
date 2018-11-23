<?php

namespace App\Services\BotPool\Bot;

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
        return !empty(self::COMMANDS[$id]);
    }

    /**
     * Установка комманды для бота
     *
     * @param int $id
     *
     * @return bool
     */
    public function setCommandId(int $id): bool
    {
        if ($this->checkCommand($id)) {
            $command = self::COMMANDS[$id];
            $this->commandId = $id;
            $this->command = new $command();
            $this->commandInfo = ['test info'];
            return true;
        }
        return false;
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

    /**
     * Инфа по комманде. Пока не нужно
     *
     * @return array
     */
    public function getCommandInfo(): array
    {
        return $this->commandInfo;
    }
}
