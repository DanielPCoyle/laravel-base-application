<?php

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

Route::get('/test', function () {
    return view('test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{entity}/test', 'BaseController@test')->name('test');

Route::get('/{entity}', 'BaseController@get')->name('get');

Route::get('/{entity}/{id}', 'BaseController@getSingle')->name('get_single'); 

Route::post('/{entity}', 'BaseController@post')->name('post'); 

Route::put('/{entity}/{id}', 'BaseController@put')->name('put'); 

Route::delete('/{entity}/{id}', 'BaseController@delete')->name('delete'); 

