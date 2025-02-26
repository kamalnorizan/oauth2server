<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function sync() {
        $users = User::all();
        return response([
            'users' => $users
        ]);
    }
}
