<?php

namespace App\Services\BotPool\Bot\Commands;

interface CommandInterface
{
    public function run($botInfo);
}
