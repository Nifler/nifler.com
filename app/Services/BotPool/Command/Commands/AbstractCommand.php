<?php

namespace App\Services\BotPool\Command\Commands;

abstract class AbstractCommand implements CommandInterface
{
    protected $botInfo;
    protected $poolInfo;

    abstract public function getInfoList(): array;
    abstract public function run(): array;

    public function setBotInfo(array $botInfo)
    {
        $this->botInfo = $botInfo;
    }

    public function setPoolInfo(array $poolInfo)
    {
        $this->poolInfo = $poolInfo;
    }
}
