<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class WalletController extends Controller
{
    public function generateWallet(request $request){

        $data = $request->validate([
            'email' => 'required|string',
            'coin_name' => 'required|string',
        ]);

        $user = Auth()->guard('user')->user();
        $wallet = Auth()->guard('user')->user()->wallet;

        //check if user is already created the request in coin_name before
        $check = $wallet->where('coin_name', $data['coin_name'])->first();
        if($check){

            $response = [
                'message' => 'Cannot generate two '.$data['coin_name']. ' wallets',
            ];

            return response()->json($response, 400);
        }

        $data = Wallet::create([
            'user_id' => $user->id,
            'email' => $data['email'],
            'coin_name' => $data['coin_name'],

        ]);

        $response = [
            'message' => $data['coin_name'].' wallet successfully created with $100.00 bonus',
        ];

        return response()->json($response, 200);
    }
}
