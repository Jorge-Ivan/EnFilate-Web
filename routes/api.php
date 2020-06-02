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

Route::get('/venues', 'HomeController@venues')->name('api.venues.index');
Route::post('/get-turn', 'TurnsController@store')->name('api.turn.create');
Route::get('/status-turn/{id}', 'TurnsController@show')->name('api.turn.show');