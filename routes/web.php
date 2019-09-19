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
class Dynamic {
  protected $methods = array();
  public static function

registerMethod($method) {
    self::$methods[] = $method;
  }
}


Route::get('/', function () {
    dd(ViewReturn());
});

function ViewReturn(){
	return "ABC";
}

Route::get('/clients', function () {
    return view('clients');
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'http://localhost:8080/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('/oauth/authorize?'.$query);
});


Route::post('/session/{variable?}','SessionController@setSession')->name("set_session");
Route::get('/session/{variable?}','SessionController@getSession')->name("get_session");
Route::get('/file/{fileName}','ContentController@download')->name("download");
Route::post('/file/{fileName?}','ContentController@upload')->name("upload");
Auth::routes();
