<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $x = $request->x;
        $y = $request->y;

        $z=$x*$y;

        return view('calc',['result' => $z]);
    }
}