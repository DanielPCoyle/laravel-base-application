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

$middleware = [];
if(app()->env == "production"){
	$middleware = ['auth:api'];
}

Route::middleware($middleware)->group(function () {

	Route::get('/{entity}/make/{count?}', 'ApiController@fixtures')->name('fixtures'); //GOOD
	Route::get('/{entity}/set/{field}/{value}/{id}', 'ApiController@set')->name('set'); //GOOD
	Route::put('/{entity}/set/{field}/{value}/{id?}', 'ApiController@set')->name('set'); //GOOD
	Route::get('/{entity}/math/{field}/{math}/{id}', 'ApiController@math')->name('math'); //GOOD
	Route::put('/{entity}/math/{field}/{math}/{id?}', 'ApiController@math')->name('math'); //GOOD

	Route::get('get', array('middleware' => 'cors', 'uses' => 'ApiController@get'));
	Route::get('/{entity}/{id?}', 'ApiController@get')->name('get_single'); //GOOD
	Route::post('/{entity}', 'ApiController@post')->name('post'); //GOOD
	Route::put('/{entity}/{id?}', 'ApiController@put')->name('put'); //GOOD
	Route::delete('/{entity}/{id?}', 'ApiController@delete')->name('delete'); //GOOD
});