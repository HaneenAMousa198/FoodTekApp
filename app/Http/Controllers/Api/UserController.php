<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //use Response;
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
            "role_id"=>'1'
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
