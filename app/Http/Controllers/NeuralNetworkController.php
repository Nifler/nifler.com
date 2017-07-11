<?php

namespace App\Http\Controllers;

use App\Models\NeuralNetwork\NeuralNetwork;

class NeuralNetworkController extends Controller
{
    public function index()
    {
        return view('neural.index');
    }
    public function show(NeuralNetwork $network){
        echo "neural";
    }
}