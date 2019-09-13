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
    return response()->json($request->user());
});

//Special


Route::get('/{entity}/set/{field}/{value}/{id}', 'ApiController@set')->name('set'); //GOOD
Route::put('/{entity}/set/{field}/{value}/{id?}', 'ApiController@set')->name('set'); //GOOD

Route::get('/{entity}/math/{field}/{math}/{id}', 'ApiController@math')->name('math'); //GOOD
Route::put('/{entity}/math/{field}/{math}/{id?}', 'ApiController@math')->name('math'); //GOOD


// Route::get('/{entity}/copy/{id}', 'ApiController@copy')->name('copy');
// Route::post('/{entity}/copy/{id?}', 'ApiController@copy')->name('copy'); 
// Route::copy('/{entity}/copy/{id}', 'ApiController@copy')->name('copy'); 

//Default
Route::get('/',function(Request $request){
    return response()->json(["status"=>"active"]);
});
Route::get('/{entity}', 'ApiController@get')->name('get'); //GOOD
Route::get('/{entity}/{id?}', 'ApiController@get')->name('get_single'); //GOOD
Route::post('/{entity}', 'ApiController@post')->name('post'); //GOOD
Route::put('/{entity}/{id?}', 'ApiController@put')->name('put'); //GOOD
Route::delete('/{entity}/{id?}', 'ApiController@delete')->name('delete'); //GOOD