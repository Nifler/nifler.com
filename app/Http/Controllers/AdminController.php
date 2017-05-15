<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{

    public function index(User $user){
        return [
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}