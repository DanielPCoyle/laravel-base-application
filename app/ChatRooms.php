<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ABC extends Model
{
	$fillable = ["user_id"];

	public function user(){
		return $this->hasOne("App\User");
	}


	public function user(){
		return $this->belongsTo("App\User");
	}

}