<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiUserController extends Controller
{
    public function sync() {
        $users = User::all();
        return response([
            'users' => $users
        ]);
    }

    public function revoketoken() {
        $token = auth()->user()->token();
        $token->revoke();

        return response([
            'message' => 'All tokens revoked'
        ]);
    }
}
