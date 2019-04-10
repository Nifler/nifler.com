<?php

namespace App\Services\BotPool\Command\Commands;

interface CommandInterface
{
    public function getInfoList(): array;
    public function run(): array;
    public function setBotInfo(array $botInfo);
    public function setPoolInfo(array $poolInfo);
}
