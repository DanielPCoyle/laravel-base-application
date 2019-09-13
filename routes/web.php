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
	$model 	 = new App\ChatMessages;
	dd($model);
	return response()->json($model);
});


Route::post('/session/{variable?}','SessionController@setSession')->name("set_session");
Route::get('/session/{variable?}','SessionController@getSession')->name("get_session");

Auth::routes();
