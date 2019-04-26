<?php

namespace App\Http\Controllers;

use App\Services\BotPool\Controller as BotPool;
use Illuminate\Support\Collection;
use Redis;

class BotPoolController extends Controller
{
    private $controller;

    public function __construct(BotPool $controller)
    {
        $this->controller = $controller;
    }

    public function index()
    {
        return $this->controller->run();
    }
}
