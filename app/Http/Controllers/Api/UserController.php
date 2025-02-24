<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerUser(Request $request){
        try{
            $request->validate([
                'name'=> 'required|string|max:50',
                'email'=> 'required|string|email|unique:users',
                'password'=>'required|min:8',
                'role' => 'required|string',
            ]);

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role' => $request->role,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user'=>$user,
                'message'=>'User Creation Successful',
                'token'=>$token
            ]);
        }

        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }
        catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message'=> 'An error has occured during registration.',
            ], 500);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Credentials',
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user -> createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'User logged in.'
        ]);
    }

    public function logOut(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out.'
        ]);
    }
}
