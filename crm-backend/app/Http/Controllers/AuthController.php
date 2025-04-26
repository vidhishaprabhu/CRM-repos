<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),

        ]);
        return response()->json(['message'=>'User registered successfully','user'=>$user]);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'

        ]);
        $user=User::create([
            'email'=>$request->email,
            'password'=>bcrypt($request->password),

        ]);
        if(!$user || Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages(['email'=>['Invalid Credentials']]);
        }
        return response()->json(['token'=>$user->createToken('api-token')->plainTextToken,'user'=>$user->load('roles')]);
    }

}
