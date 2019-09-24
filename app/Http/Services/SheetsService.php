<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SheetsService 
{

	private $relationships = ["hasOne","hasMany","belongsTo","belongsToMany","hasOneThrough","hasManyThrough"];
	private $fieldAttributesArray = ["fillable","hidden","casts","dates"];

		public function modelContent($className,$data = null){
		$content = 
<<< EOT
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class $className extends Model
{
EOT;
	foreach($this->fieldAttributesArray as $type){
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
			$array = [];
			if(!is_null($data)){
				foreach($data as $item){
					if(isset($item->$type) ){
						if(trim(strtolower($item->$type)) == "true"){
							$array[] = $item->field;
						}
					}
				}
			}
			$content = "\n protected \$$type = ['".join("','",$array)."'];";
			return $content;
		}

		public function relationships($type,$data){
			$content = "";
				foreach ($data as $field) {
					if(isset($field->$type)){
						$fieldName = str_replace("_id", "", $field->field);
						$fieldName = str_replace('_', ' ',$fieldName);
						$fieldName = ucwords($fieldName);
						$func = lcfirst($fieldName);
						$class = "App\\".str_replace(" ","",$fieldName);
					

$content .= 
<<< EOT


	public function $func(){
		return \$this->$type("$class");
	}

EOT;
}
			}
			return $content;
		}


		public function migrationContent($name,$data){
			$tableName = strtolower($name);
			$name = str_replace('_', ' ',$name);
			$name = ucwords($name);
			$name = str_replace(" ","",$name);
			$class = "Create".$name."Table";
			$up = $this->upContent($data);
			$down = $this->downContent($tableName);
			return $contnet = 
<<< EOT
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class $class extends Migration
{
	public \$table_name = "$tableName";

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

		public function upContent($data){
			$content = "";
			$this->migrationDropColumn($data);
			$content .= $this->createTable($data)."\n\t\t";
			$content .=  "else ".$this->modfiyTable($data);
			return $content;
		}

		public function createTable($data){
			$content = " if (!Schema::hasTable(\$this->table_name)) {\n\t\t\tSchema::create(\$this->table_name, function (Blueprint \$table) {\n";
			
			foreach ($data as $field) {
				$content .= "\t".$this->migrationField($field);
			}

			$content .="\n\t\t\t//Indexes\n";
			foreach ($data as $field) {
				$content .= "\t".$this->migrationIndexes($field);
			}

			$content .="\n\t\t\t//foreign\n";
			foreach ($data as $field) {
				$content .= "\t".$this->migrationForeign($field);
			}

			$content .="\n\t\t\t});";
			$content .="\n\t\t}";
			return $content;
		}
		public function modfiyTable($data){
			$content = " if (Schema::hasTable(\$this->table_name)) {\n\t\t\tSchema::table(\$this->table_name, function (Blueprint \$table) {\n";
			
			foreach ($data as $field) {
				$content .="\n\t\t\t\tif(!Schema::hasColumn(\$this->table_name, '".$field->field."')){\n";
				$content .= "\t".$this->migrationField($field);
				$content .= "\n\t\t\t\t} else {\n";
				$content .= "\t".$this->migrationField($field,true);
				$content .= "\t\t\t\t}";

			}

			$content .="\n\t\t\t//Indexes\n";
			foreach ($data as $field) {
				$content .= "\t".$this->migrationIndexes($field,true);
			}

			$content .="\n\t\t\t//foreign\n";
			foreach ($data as $field) {
				$content .= "\t".$this->migrationForeign($field,true);
			}

			$content .="\n\t\t\t//Dropped Columns\n";
			$content .= $this->migrationDropColumn($data);

			$content .="\n\t\t\t});";
			$content .="\n\t\t}";
			return $content;
		}
		public function downContent($tableName){
			$content = "\n\t\t\t\tSchema::dropIfExists('$tableName');";
			return $content;
		}
		public function migrationField($field,$change = false){
			$content = "";
			if(!isset($field->type)){
				throw new Exception("Every line needs a type", 1);
			
			}
			if(strtolower($field->type) == "char" ||
				strtolower($field->type) == "string"){
				$content .= "\t\t\$table->".$field->type."('".$field->field."',".($field->length ?? 255).")";
			} else if (strtolower($field->type) == "decimal" || strtolower($field->type) == "double" ||
				strtolower($field->type) == "float" ||
				strtolower($field->type) == "unsignedDecimal"){
				$content .= "\t\t\$table->".$field->type."('".$field->field."',".$field->precision.",".$field->scale.")";
			} else if (strtolower($field->type) == "enum" ||
			   strtolower($field->type) == "set"){
			   	$choices = "'".str_replace(",", "','", $field->choices)."'";
				$content .= "\t\t\$table->".$field->type."('".$field->field."',[".$choices."])";
			} else{
				$content .= "\t\t\$table->".$field->type."('".$field->field."')";
			}
			foreach (["first", "after", "useCurrent", "autoIncrement", "always", "nullable","unsigned"] as $func) {
				if(isset($field->$func) &&  strtolower($field->$func) == "true"){
					$content .="->$func()";
				} 
			}
			foreach(["charset", "default", "storedAs", "virtualAs", "generatedAs",] as $func){
				if(isset($field->$func)){
					$content .="->$func('".$field->$func."')";
				}
			}

			$content .= "->comment('";
			$content .= json_encode(
				[
					"form"=>$this->formMetaBuild($field),
					"list"=>$this->listMetaBuild($field),
				]
			);
			$content .="')";
			if($content != ""){
				if($change === true){
					$content .= "->change()";
				}
				return "\t\t".$content.";\n";
			}
				return $content;
		}


		public function migrationIndexes($field,$change = false){
			$content = "";
			foreach(["primary","unique","index","spatialIndex"] as $func){
				if(isset($field->$func) &&  strtolower($field->$func) == "true"){
					$content .= "\t\$table->$func('".$field->field."')";
				}
			}
			if($content != ""){
				if($change === true){
					$content .= "->change()";
				}
				return "\t\t".$content.";\n";
			}
				return $content;
		}

		public function migrationForeign($field,$change = false){
			$content = "";
			if(isset($field->foreign)){
				$content .= "\$table->foreign('".$field->field."')->references('id')->on('".$field->foreign."')";
			}
			if($content != ""){
				if($change === true){
					$content .= "->change()";
				}
				return "\t\t".$content.";\n";
			}
				return $content;
		}

		public function migrationDropColumn($data){
			$content = "";
			$path = app_path()."\\database\\lastSheetSync.json";
			$path =str_replace("/app", "", $path);
			$path =str_replace("\\app", "", $path);
			if(file_exists($path)){
				$last = file_get_contents($path);
				if(trim($last) !== ""){
					$last = json_decode($last);
					foreach ($last as $key => $value) {
						if(!isset($data[$key])){
							$content .="\n\tif(Schema::hasColumn(\$this->table_name, '".$key."')){\n";
							$content .= "\t\t\$table->dropColumn('".$key."');";
							$content .= "\n\t}";
						}
					}
					if($content != ""){
						return "\t\t".$content."\n";
					}
					return $content;
				}
			}
		}


    public function sheetData($client, string $sheetId, string $sheet,$ranges = "A1:DF300")
    {
        $service = new \Google_Service_Sheets($client);
        if($ranges == "header"){
            $response = $service->spreadsheets_values->get($sheetId, $sheet."!A1:DF1");
            foreach($response->values[0] as $i => $col){
             $header[$i] = lcfirst($col);
            } 
            return $header;
        }
        $range = $sheet."!".$ranges;
        $response = $service->spreadsheets_values->get($sheetId, $range);
        foreach($response->values[0] as $i => $col){
                $header[$i] = lcfirst($col);
        } 
        unset($response->values[0]);
        $sheetData = [];
        foreach($response->values as $row){
            $obj = new \stdClass();
            foreach($header as $pos => $name ){
                if(!empty($row[$pos])){
                    if($name == "field"){
                        $row[$pos] = $this->fieldCase($row[$pos]);
                    }
                    $obj->$name = $row[$pos];
                }
            } 
            if(!empty((array) $obj)) {
                $sheetData[] = $obj;
            }
        } 
        return $sheetData;
    }

    public function fieldCase($fieldName,$type = "underscore"){
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        if($type == "underscore"){
            $replace = '${1}_${2}';
            return strtolower(preg_replace($pattern,$replace,$fieldName));
        }
        if($type == "camelCase"){
            $fieldName = ucwords(str_replace("_", " ", $fieldName));
            $fieldName = lcfirst(str_replace(" ", "", $fieldName));
            return $fieldName;
        }
    }

    private function defaultValueCheck($obj)
    {

        if(empty($obj->precision)) {
            $obj->precision = 10; 
        }
        if(empty($obj->scale)) { 
            $obj->scale = 0; 
        }
        if(empty($obj->options)) { 
            $obj->options = "false"; 
        }
        if(empty($obj->name)) { 
            $obj->name = $this->fieldCase($obj->field); 
        }
        if(empty($obj->referencedColumnName)) { 
            $obj->referencedColumnName =  "id"; 
        }
        if(empty($obj->description)) { 
            $obj->description = ""; 
        }
            return $obj;       
    }

   public function fieldDataFormat($data)
    {
        $output = [];
        foreach($data as $field){
            $output[$field->entity][$field->field] = $this->defaultValueCheck($field);
        }
        return $output;
    }

    private function defaultformmeta($field){
        $meta = [];
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        $replace = '${1} ${2}';
        $meta['label'] = ucfirst(preg_replace($pattern,$replace,$field->field));
        $meta['label'] = str_replace("_", " ", $meta['label']);
        $meta['sort'] = 999;
        $meta['key'] =  $this->fieldCase($field->field,"camelCase");
        $meta['data_type'] = $field->type;
        if($field->type == "integer"){
            $meta['value'] = 0;
            $meta['type'] = "number";
        }
        if(in_array($field->type,["array","ManyToMany","ManyToOne","OneToMany"])){
            $meta['value'] = (array) [];
            $meta['type'] = "select";
        }
        if($field->type == "text"){
            $meta['type'] = "textarea";
            $meta['source_view'] = false;
        }
        if($field->type == "string"){
            $meta['type'] = "text";
        }
        if($field->type == "datetime"){
            $meta['type'] = "datetime";
        }
        if($field->type == "boolean"){
            $meta['type'] = "boolean";
        }
        else{
            $meta['value'] = (string) '';
        }
        return $meta;
    }

    private function formMetaBuild(object $field){
        $meta = $this->defaultformmeta($field);
        if(!empty($field->choices)){
            $choices = explode(",",$field->choices);
            foreach($choices as $choice){
                if(strpos($choice, ":")> 0){
                    $choice = explode(":",$choice);
                    $meta['options'][$choice[0]] = $choice[1];
                } else{

                    $meta['options'][] = $choice;
                }
            }
        }
        if(!empty($field->targetEntity)){
            $meta['options'] = [];
            $meta['target'] = $field->targetEntity;
        }

        foreach($field as $attrKey => $attrVal){
            if(in_array("formmeta", explode("_", $attrKey))) {
                $attrKey = (string) explode("formmeta",$attrKey)[1];
                $attrKey = trim($attrKey,"_"); 
                $meta[$attrKey] = (string) trim($attrVal);
                
                if( "true" == strtolower($attrVal) || "false" == strtolower($attrVal)){
                    $meta[$attrKey] = (strtolower($attrVal) == "true") ? true : false;    
                } 
            }
        }
        if(!empty(trim($field->description))){
            array_unshift($contents,"* ".$field->description);
        }
        return $meta;
    }

    private function listMetaBuild(object $field){
        $meta = [];
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        $replace = '${1} ${2}';
        $meta['label'] = ucfirst(preg_replace($pattern,$replace,$field->field));
        $meta['label'] = str_replace("_", " ", $meta['label']);
        $meta['key'] =  $this->fieldCase($field->field,"camelCase");
        $meta['data_type'] = $field->type;
        if(!empty($field->targetEntity)){
            $meta['options'] = [];
            $meta['target'] = $field->targetEntity;
        }
        foreach($field as $attrKey => $attrVal){
            if(in_array("tableMeta", explode("_", $attrKey))) {
                $attrKey = (string) explode("tableMeta",$attrKey)[1];
                $attrKey = trim($attrKey,"_"); 
                $meta[$attrKey] = (string) trim($attrVal);
                if( "true" == strtolower($attrVal) || "false" == strtolower($attrVal)){
                    $meta[$attrKey] = (strtolower($attrVal) == "true") ? true : false;    
                } 
            }
        }
        if(!empty(trim($field->description))){
            array_unshift($contents,"* ".$field->description);
        }
        return $meta;
    }
}
