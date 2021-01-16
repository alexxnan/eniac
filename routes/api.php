<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('user','App\Http\Controllers\API\UserController');
Route::apiResource('profile','App\Http\Controllers\API\UserController');

Route::get('profile','App\Http\Controllers\API\UserController@profile');
Route::get('findUser', 'App\Http\Controllers\API\UserController@search');
Route::get('comanda', 'App\Http\Controllers\API\ComenziController@create');
Route::put('profile', 'App\Http\Controllers\API\UserController@updateProfile');
