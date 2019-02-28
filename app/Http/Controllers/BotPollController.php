<?php

namespace App\Http\Controllers;

use App\Services\BotPool\Bot\Bot;
use App\Services\BotPool\Pool\Pool;
use App\Services\BotPool\Controller as BotPoolController;

class BotPollController extends Controller
{

    private $bot;
    private $pool;
    private $controller;

    public function __construct(Bot $bot, Pool $pool, BotPoolController $controller)
    {
        $this->bot = $bot;
        $this->pool = $pool;
        $this->controller = $controller;
    }

    public function index()
    {
        $this->controller->run();
        //for commit
    }
}
