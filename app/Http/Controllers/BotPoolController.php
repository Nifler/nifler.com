<?php

namespace App\Http\Controllers;

use App\Services\BotPool\Controller as BotPool;

class BotPoolController extends Controller
{
    private $controller;

    public function __construct(BotPool $controller)
    {
        $this->controller = $controller;
    }

    public function index()
    {
        return view('BotPool.pool');
    }

    public function run()
    {
        return 'test';
        $data = $this->controller->run();
        return json_encode($data);
    }
}
