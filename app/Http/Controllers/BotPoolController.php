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
        $data = $this->controller->run();
        if(isset($_GET['t'])) {
            dd($data);
        }
        $res = [
            'dimensions' => $data['dimensions']
        ];

        $pixels = [];
        foreach ($data['itemPixelRelation'] as $key => $pixel) {
            $pixels[$pixel] = $key;
        }
        $res['population'] = $data['population'];

        foreach ($res['population'] as &$bot) {
            unset($bot['genome']);
        }

        $res['pixels'] = $pixels;

        return json_encode($res);
    }

    public function renew()
    {
        $this->controller->renew();
    }
}
