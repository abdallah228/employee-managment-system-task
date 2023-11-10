<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request){
    	$validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (!$token = auth()->guard('api')->attempt($validator)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }


    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->guard('api')->user()
        ]);
    }



    public function logout() {
        auth()->guard('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
