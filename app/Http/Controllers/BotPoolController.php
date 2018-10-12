<?php

namespace App\Http\Controllers;

use App\Services\BotPool\Bot;

class BotPoolController extends Controller
{

    private $bot;

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
    }

    public function index()
    {
        dd($this->bot);
    }


}