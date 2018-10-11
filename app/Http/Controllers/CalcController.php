<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Bot;

class CalcController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calc');
    }

    public function store(Request $request){

        $num1 = $request->num1;
        $num2 = $request->num2;
        $sign = $request->sign;

        $formula = new Bot($num1, $num2);

        return view('calc',['result' => $formula->calculate($sign)]);
    }
}