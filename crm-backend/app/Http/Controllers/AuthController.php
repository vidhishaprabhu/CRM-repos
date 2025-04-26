<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        if (Str::endsWith($user->email, '@admin.com')) {
            $user->assignRole('Admin');
        } elseif(Str::endsWith($user->email,'@sales.com')) {
            $user->assignRole('Sales Manager');
        }
        elseif(Str::endsWith($user->email,'@support.com')){
            $user->assignRole('Support');
        }    
        return response()->json(['message'=>'User registered successfully','user'=>$user]);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'

        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages(['email'=>['Invalid Credentials']]);
        }
        return response()->json(['token'=>$user->createToken('api-token')->plainTextToken,'user'=>$user->load('roles')]);
    }

}
