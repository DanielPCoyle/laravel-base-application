<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseApiModel extends Model
{
	public function getMeta($type){
		$metaType = $type."Meta";
		if($this->$metaType){
			return json_decode($this->$metaType);
		} else {
			return null;
		}
	}
}