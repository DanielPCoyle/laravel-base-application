<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    protected $table = "item";
 protected $fillable = ['name','price','description','category_id'];
 protected $hidden = [''];
 protected $casts = [''];
 protected $dates = [''];

	public function category() {
		return $this->belongsTo("App\Category");
	}

}