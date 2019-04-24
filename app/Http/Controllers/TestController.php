<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function request()
    {


        $path = resource_path() . '/request.txt';

        $contents = \File::get($path);

        $contents2 = $contents . ' - ' . time();

        if(!isset($_GET['hide'])) {
            \File::put($path, $contents2);
        }

        if(isset($_GET['clear'])) {
            \File::put($path, '');
        }



        dd($contents);
    }

}