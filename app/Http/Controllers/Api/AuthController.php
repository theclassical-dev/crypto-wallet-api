<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'phone' => $data['phone'],
            'password' => bcrypt($data['password'])
        ]);

        // $token = $user->createToken('accessToken')->plainTextToken;

        $response = [
            'user' => $user,
            // 'token' => $token
        ];

        return response($response, 201);
    }

    public function getAccessToken(Request $request){

        $data = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        //check phone number
        $user =  User::where('phone', $data['phone'])->first();

        //check if password matches
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response(['message' => 'Unauthorized']);
        }

        $token = $user->createToken('accessToken')->plainTextToken;

        $response = [
            // 'user' => $user,
            'token' => $token
        ];

        return response($response);

    }
}
