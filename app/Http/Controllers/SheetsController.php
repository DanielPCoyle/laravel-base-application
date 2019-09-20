<?php

namespace App\Http\Controllers;

use App\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\QueryService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SheetsController extends Controller
{
	public function writeModelFile(){
		$path = app_path().'/ChatRooms.php';
		$h = fopen($path, "w");
		$data = new \StdClass();
		$data->fillable = ["user_id"];
		$data->belongsTo = ["user_id"];
		$data->hasOne = ["user_id"];
		fwrite($h, $this->modelContent("ABC",$data));
		fclose($h);
	}

	public function modelContent($className,$data = null){
		$content = <<< EOT
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class $className extends Model
{
EOT;
			foreach(["fillable"] as $type){
				$content .= $this->fieldTypes($type,$data);
			}


			foreach (["hasOne","hasMany","belongsTo","belongsToMany","hasOneThrough","hasManyThrough"] as  $type) {
				$content .= $this->relationships($type,$data);
			}

			$content .= "\n}";
			return $content;
		}


		public function fieldTypes($type,$data){
			$content = "";
			if(!is_null($data)){
				if(isset($data->$type) && count($data->$type) > 0){
					$array = "\"".join("','",$data->$type)."\"";
					$content .= "\n\t\$fillable = [".$array."];";
				}
			}
			return $content;
		}

		public function relationships($type,$data){
			$content = "";
			if(isset($data->$type) && count($data->$type) > 0){
				foreach ($data->$type as $field) {
					$field = str_replace("_id", "", $field);
					$field = str_replace('_', ' ',$field);
					$field = ucwords($field);
					$func = lcfirst($field);
					$class = "App\\".str_replace(" ","",$field);

					$content .= <<< EOT


	public function $func(){
		return \$this->$type("$class");
	}

EOT;
				}
			}
			return $content;
		}

	}

