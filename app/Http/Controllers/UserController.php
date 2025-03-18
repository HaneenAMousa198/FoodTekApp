<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Response;

class UserController extends Controller
{
    public function register(request $request)
    {
        $request->validate([
            'full_name'=>'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed',
            'phone_number'=>'required|string|max:20',
            'birth_date'=>'required|date',
        ]);
        $user=User::create([
            'full_name'=>$request->full_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'birth_date'=>$request->birth_date,
        ]);
        return response()->json([
            'message'=>'User Registered Suuccessfuly',
            'User'=>$user,
            201,
        ]);
    }


    public function login(request $request)
    {
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        //تحقق من ال email & password 
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }
        //Token 
        $user = User::where('email', $request->email)->first();
        $token=$user->createToken('auth_Token')->plainTextToken;
        return response()->json([
            'message'=>'User Login Suuccessfuly',
            'User'=>$user,
            'Token'=>$token
        ],201);
    }




    public function  logout(request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'Logout Successful'
        ]);



    }
}
