<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{

    protected $history;
    protected $user;

    public function __construct()
    {

        $this->history = Auth()->guard('user')->user()->transaction;
        $this->user = Auth()->guard('user')->user();
    }


    public function get_all_transactions(Request $request)
    {


        $transaction = $this->history;

        $response = [
            'data' => $transaction
        ];

        return response()->json($response, 200);
    }

    public function getSpecificCoinTransactions(Request $request)
    {

        $data = $request->validate(['coin_name' => 'required']);

        $transaction = $this->history;

        $check = $transaction->where('coin_name', $data['coin_name']);

        if ($check) {

            $response = [
                'data' => $check
            ];

            return response()->json($response, 200);
        } else {

            $response = [
                'message' => "No transaction found"
            ];

            return response()->json($response, 400);
        }
    }
}
