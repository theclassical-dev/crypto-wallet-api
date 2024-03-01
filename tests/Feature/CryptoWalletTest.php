<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CryptoWalletTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_registration()
    {
        $data = [
            'phone' => '888',
            'password' => '099',
        ];

        try {
            $response = $this->post('/api/register', $data);

            if ($response->status() === 201) {
                $response->assertStatus(201);
                print("Register successfully");
            } elseif ($response->status() === 302) {
                $response->assertStatus(302);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_token_request()
    {

        $data = [
            'phone' => '888',
            'password' => '009',
        ];

        try {
            $response = $this->post('/api/token', $data);

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['token'])  . "\n");
            } elseif ($response->status() === 302) {
                $response->assertStatus(302);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_generate_Wallet()
    {

        // $response = $this->get('/');

        // $response->assertStatus(200);
        $data = [
            'email' => 'test@gmail.com',
            'coin_name' => 'btc',
        ];

        $token = "";

        try {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
                ->post('/api/user/generate-wallet', $data);

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['message'])  . "\n");
            } elseif ($response->status() === 302) {
                $response->assertStatus(302);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } elseif ($response->status() === 400) {
                $response->assertStatus(400);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_get_balance()
    {

        $data = [
            'coin_name' => 'btc',
        ];

        $token = "";

        try {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
                ->post('/api/user/balance', $data);

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['data'])  . "\n");
            } elseif ($response->status() === 302) {
                $response->assertStatus(302);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } elseif ($response->status() === 400) {
                $response->assertStatus(400);
                $message = $response->json();
                print(json_encode($message['message']) . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_all_wallets()
    {

        $token = "";

        try {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('/api/user/wallets');

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['data'])  . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_transfer_request()
    {

        $data = [
            'receivers_email' => 'test@gmail.com',
            'sending_coin' => 'btc',
            'coin_name' => 'btc',
            'amount' => '5.00',
        ];

        $token = "";

        try {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('/api/user/transfer', $data);

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['message'])  . "\n");
            } elseif ($response->status() === 302) {
                $response->assertStatus(302);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } elseif ($response->status() === 400) {
                $response->assertStatus(400);
                $message = $response->json();
                print(json_encode($message['message']) . "\n");
            }elseif ($response->status() === 401){
                $response->assertStatus(401);
                $message = $response->json();
                print(json_encode($message['message']) . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_all_transactions()
    {

        $token = "";

        try {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('/api/user/all-transactions');

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['data'])  . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
    public function test_wallet_transaction()
    {

        $data = [
            'coin_name' => 'btc',
        ];

        $token = "";

        try {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('/api/user/transaction', $data);

            if ($response->status() === 200) {
                $response->assertStatus(200);
                print(json_encode($response['data'])  . "\n");
            } elseif ($response->status() === 302) {
                $response->assertStatus(302);
                $message = $response->json();
                print(json_encode($message) . "\n");
            } elseif ($response->status() === 400) {
                $response->assertStatus(400);
                $message = $response->json();
                print(json_encode($message['message']) . "\n");
            } else {
                print($response->status() . "\n");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            print(json_encode($errors) . "\n");
        }
    }
}
