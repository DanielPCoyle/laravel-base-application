<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SheetsService 
{

	private $relationships = ["hasOne","hasMany","belongsTo","belongsToMany","hasOneThrough","hasManyThrough"];
	private $fieldAttributes = ["fillable","hidden","casts","dates"];

		public function modelContent($className,$data = null){
		$content = <<< EOT
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class $className extends Model
{
EOT;

	foreach($this->fieldAttributes as $type){
		$content .= $this->fieldAttributes($type,$data);
	}

	foreach ($this->relationships as  $type) {
		$content .= $this->relationships($type,$data);
	}

	$content .= "\n}";
	return $content;
}

		public function fieldAttributes($type,$data){
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


		public function migrationContent($name,$data){
			$tableName = $name;
			$name = str_replace('_', ' ',$name);
			$name = ucwords($name);
			$name = str_replace(" ","",$name);
			$class = "Create".$name."Table";
			$up = $this->upContent($tableName,$data);
			$down = $this->downContent($tableName);
			return $contnet = <<< EOT
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class $class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $up
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $down
    }
}
EOT;
		}

		public function upContent($tableName,$data){
			$content = "Schema::create('$tableName', function (Blueprint \$table) {\n";
			$content .="\n}";
			return $content;
		}
		public function downContent($tableName){
			$content = "\n\nSchema::dropIfExists($tableName);";
			return $content;
		}
		public function migrationField($data){
			$content = "";
			return $content;
		}
}
