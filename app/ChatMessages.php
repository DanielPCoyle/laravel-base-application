<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ChatMessages extends Model
{
	use SoftDeletes;
	protected $fillable = ["message","user_id"];

	protected $associative = ["user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
