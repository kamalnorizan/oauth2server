<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'application_name' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        $scope = [];
        if($request->application_name == 'eWallet') {
           $scope = ['profile-user','access-wallet','transfer-funds'];
           $token = $user->createToken($request->application_name, $scope)->accessToken;
        }else{
            $scope = ['profile-user'];
            $token = $user->createToken($request->application_name, $scope)->accessToken;
        }

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
}
