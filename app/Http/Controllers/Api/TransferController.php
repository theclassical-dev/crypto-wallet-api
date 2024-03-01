<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function transferFunds(Request $request){

        $data = $request->validate([
            'receivers_email' => 'required',
            'sending_coin' => 'required',
            'coin_name' => 'required',
            'amount' => 'required',
        ]);

        $wallet = Auth()->guard('user')->user()->wallet;

        $user = Auth()->guard('user')->user();

        $sendersData = $wallet->where('coin_name', $data['sending_coin'])->first();
        $sendersBalance = $sendersData->balance;

        $receiversData = Wallet::where('email', $data['receivers_email'])->where('coin_name', $data['coin_name'])->first();

        $receiversBalance = $receiversData->balance;


        //check for email address in wallet
        $check = Wallet::where('email',$data['receivers_email'])->first();

        if(!$check){
            
            $response = [
                'message' => 'Invalid email address'
            ];

            return response()->json($response, 401);
        }

        if($data['sending_coin'] != $data['coin_name']){

            $response = [
                'message' => 'Cannot send '.$data['sending_coin'].' to '.$data['coin_name']. ' wallet'
            ];

            return response()->json($response);
        } 

        $a = (float)$data['amount'];
        $b = (float)$sendersBalance;
    
        if($a > $b){

            $response = [
                'message' => 'Insufficient funds'
            ];

            return response()->json($response, 400);
        }

        $senderNewBalance = (float)$sendersBalance - (float)$data['amount'];
        $receiversNewBalance = (float)$receiversBalance + (float)$data['amount'];

        //update balance
        $updateSendersBalance = $sendersData->update([
            'balance' => $senderNewBalance
        ]);
        
        $updateReceiversbalance = $receiversData->update([
            'balance' => $receiversNewBalance
        ]);

        

        if($updateSendersBalance && $updateReceiversbalance){

            Transaction::create([
                'user_id' => $user->id, 
                'senders_email' => $sendersData->email,
                'receiver_email' => $receiversData->email,
                'coin_name' => $data['coin_name'],
                'amount' => $data['amount'],
            ]);

            $response = [
                'message' => '$'. $data['amount'] .' successfully sent to '. $data['receivers_email']
            ];

            return response()->json($response);

        }


    }
}
