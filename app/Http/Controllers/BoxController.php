<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoxController extends Controller
{

    public function index(Request $request)
    {
        return view('box',[
            'callbackUrl' => $request->input('redirect_to_box_url')
        ]);
    }

}