<?php

use Illuminate\Http\Request;

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

Route::get('/{entity}', 'BaseController@get')->name('get');

Route::get('/{entity}/{id}', 'BaseController@getSingle')->name('get_single'); 

Route::post('/{entity}', 'BaseController@post')->name('post'); 

Route::put('/{entity}/{id}', 'BaseController@put')->name('put'); 

Route::delete('/{entity}/{id}', 'BaseController@delete')->name('delete'); 