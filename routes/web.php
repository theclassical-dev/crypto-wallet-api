<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $apiJsonDoc = base_path('openapi.json');

    //check if the json file exists
    if(!File::exists($apiJsonDoc)){
        logger("OpenAPI JSON file not found: $apiJsonDoc");
        dd("OpenAPI JSON file not found: $apiJsonDoc");
    }

    $apiDoc = File::get($apiJsonDoc);

    // return view('welcome');
    return view('apidoc', ['apiDoc' => $apiDoc]);
});
