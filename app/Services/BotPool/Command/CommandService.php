<?php

namespace App\Services\BotPool\Command;

use App\Services\BotPool\Command\Commands\CommandInterface;
use App\Services\BotPool\Command\Commands\Move;
use App\Services\BotPool\Command\Commands\Photosynthesis;

class CommandService
{
    // соответствие ид генома к комманде. это безобразие переделать через конфиг
    const COMMANDS = [
        1 => Move::class,
        2 => Photosynthesis::class
    ];

    private $commandId;

    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * Установка комманды для бота
     *
     * @param int $id
     *
     * @return bool
     */
    public function setCommand(int $id): bool
    {
        $class = self::COMMANDS[$id];
        $this->commandId = $id;
        $this->command = new $class();

        return true;
    }

    public function getReuiredInformationList()
    {
        return $this->command->getInfoList();
    }

    public function getCommandList(): array
    {
        return self::COMMANDS;
    }

    public function runCommand(array $botInfo, array $poolInfo)
    {
        $this->command->setBotInfo($botInfo);
        $this->command->setPoolInfo($poolInfo);

        return $this->command->run();
    }
}
