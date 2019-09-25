<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = "category";
 protected $fillable = ['name'];
 protected $hidden = [''];
 protected $casts = [''];
 protected $dates = [''];
}