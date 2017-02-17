<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Calc;

class CalcController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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

        $formula = new Calc($num1, $num2);

        $result = $formula->calculate($sign);

        return view('calc',['result' => $result]);
    }
}