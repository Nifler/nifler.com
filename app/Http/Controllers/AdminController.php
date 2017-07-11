<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{

    public function index() {
        $list =[];
        foreach ( User::all() as $user) {
            $list[] = [
                'name' => $user->name,
                'email' => $user->email
            ];
        }
        return $list;
    }

    public function show(User $user) {
        return [
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}