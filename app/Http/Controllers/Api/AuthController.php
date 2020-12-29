<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
        $this->middleware('guest')->only('login');
    }
    
    public function login (Request $request) 
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
            // return response()->json(['message' => 'El email o la contraseña son incorrectos'])->status(422);
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['data' => ['name' => $user->name, 'email' => $user->email, 'token' => $token]]);
    }
    
    public function logout(Request $request)
    {
        // https://stackoverflow.com/a/62497133
        
        // Get user who requested the logout
        $user = $request->user(); //or Auth::user()
        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        
        return response()->json(null, 204);
    }
    
    public function user (Request $request)
    {
        return $request->user();
    }
}
