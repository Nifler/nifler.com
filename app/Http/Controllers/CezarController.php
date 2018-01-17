<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CezarController extends Controller
{

    public function index()
    {
        return view('Cezar.Learning');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'key' => 'required|filled|unique:cezar_lang|max:255',
            'text' => 'required|string',
        ]);
        dd($validatedData);
    }

}