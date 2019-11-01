<?php
/**
 * The CustomService
 */
namespace App\Http\Services\Custom;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The CustomService class is used to help 
 * handle requests in the API. 
 */
class GetService
{
	public function instanceBehaviors(){
		dump("Response from Instance 1");
	}
}