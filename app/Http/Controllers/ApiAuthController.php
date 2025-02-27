<?php

namespace App\Http\Controllers;

use App\Models\SubSystem;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
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
        if($request->application_name!= null){
            $subSystem = SubSystem::where('name', $request->application_name)->first();

            $scopes = $subSystem->scopes;
            foreach ($scopes as $scopeItem) {
                $scope[] = $scopeItem->scope;
            }
        }

        $token = $user->createToken($request->application_name, $scope)->accessToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $token = $user->token();
            $token->revoke();

            // Also revoke refresh tokens
            RefreshToken::where('access_token_id', $token->id)->update(['revoked' => true]);

            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
