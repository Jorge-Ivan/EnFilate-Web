<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home.turns');

Route::post('/tomar-turno', 'TurnsController@store')->name('turn.create');

Route::group(['middleware' => ['auth']], function()
{
	Route::get('/gestion', 'TurnsController@index')->name('home');
	Route::put('/turno/{id}', 'TurnsController@update')->name('turn.update');
});