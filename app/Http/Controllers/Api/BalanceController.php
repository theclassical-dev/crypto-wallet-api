<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BalanceController extends Controller
{

    public function getBalance(Request $request)
    {

        $data = $request->validate([
            'coin_name' => 'required|string',
        ]);

        $data['convert_from'] = 'usd';
        $user = Auth()->guard('user')->user();

        $wallet = $user->wallet;

        $check_con_to = $wallet->where('coin_name', $data['coin_name'])
            ->first();

        // check for wallets
        if ($check_con_to == null) {

            $response = [
                'data' => 'You no wallet is available for ' . $data['coin_name'],
            ];

            return response()->json($response, 200);
        }

        if ((float)$check_con_to->balance != (float)0.00 && $check_con_to->balance != null) {

            $liveMarketPrice = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $data['convert_from'],
                'vs_currencies' => $data['coin_name'],
            ]);

            if ($liveMarketPrice->successful()) {

                $controlPrice  = $liveMarketPrice->json()[$data['convert_from']][$data['coin_name']];

                $convertBalance = $check_con_to->balance * $controlPrice;

                //update market price
                $check_con_to->update([
                    'market_price' => $convertBalance
                ]);

                $response = [
                    'data' => [
                        'wallet' => $data['coin_name'],
                        'balance' => $convertBalance,
                    ],
                ];

                return response()->json($response);
            } else {
                $response = [
                    'message' => "Server error",
                ];

                return response()->json($response, 500);
            }
        } else {

            $response = [
                'message' => 'Insufficient funds',
            ];

            return response()->json($response, 400);
        }
    }
    public function all_balance()
    {

        $user = auth()->guard('user')->user();
        $convert_from = 'usd';

        if (!$user->wallet || $user->wallet->isEmpty()) {

            $response = [
                'message' => 'No wallets found',
            ];

            return response()->json($response, 400);
        }

        $walletInfo = [];

        foreach ($user->wallet as $wallet) {
            $convert_to = $wallet->coin_name;

            $liveMarketPrice = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $convert_from,
                'vs_currencies' => $convert_to,
            ]);

            if ($liveMarketPrice->successful()) {

                $conversionRate = $liveMarketPrice->json()[$convert_from][$convert_to];

                $convertedBalance = $wallet->balance * $conversionRate;

                $wallet->update([
                    'market_price' => $convertedBalance,
                ]);

                $walletInfo[] = [
                    'wallet' => $convert_to,
                    'balance_usd' => $wallet->balance,
                    'converted_balance' => $convertedBalance,
                ];

            } else {
                $response = [
                    'message' => "Server error",
                ];

                return response()->json($response, 500);
            }
        }

        $response = [
            'data' => $walletInfo,
        ];

        return response()->json($response);
    }
}
