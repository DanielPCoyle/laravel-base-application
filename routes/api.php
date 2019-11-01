<?php

use Illuminate\Http\Request;

$middleware = [];
if(app()->env == "production"){
	$middleware = ['auth:api'];
}

Route::domain('{instance}.develapme.youngjedi.com')->group(function ($router) {
	Route::get('/entity-list', 'ApiController@entityList')->name('navigation');
	Route::get('/{entity}/make/{count?}', 'ApiController@fixtures')->name('fixtures'); 

	Route::get('/{entity}/meta/{type}', 'ApiController@meta')->name('meta'); 

	Route::get('/{entity}/set/{field}/{value}/{id}', 'ApiController@set')->name('set'); 
	Route::put('/{entity}/set/{field}/{value}/{id?}', 'ApiController@set')->name('set'); 
	Route::get('/{entity}/math/{field}/{math}/{id}', 'ApiController@math')->name('math'); 
	Route::put('/{entity}/math/{field}/{math}/{id?}', 'ApiController@math')->name('math'); 

	Route::get('get', array('middleware' => 'cors', 'uses' => 'ApiController@get'));
	Route::get('/{entity}/{id?}', 'ApiController@get')->name('get_single'); 
	Route::post('/{entity}', 'ApiController@post')->name('post'); 
	Route::put('/{entity}/{id?}', 'ApiController@put')->name('put'); 
	Route::post('/{entity}/{id?}', 'ApiController@put')->name('put'); 
	Route::delete('/{entity}/{id?}', 'ApiController@delete')->name('delete'); 
});

