<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The SheetService Class is used to 
 */
class SheetsService
{

    protected $relationships = [
        "hasOne",
        "hasMany",
        "belongsTo",
        "belongsToMany",
        "hasOneThrough",
        "hasManyThrough"
    ];
    
    protected $fieldAttributesArray = [
    "fillable",
    "hidden",
    "casts",
    "dates"
    ];

    /**
     * [modelContent description]
     * 
     * @param [type] $className [description]
     * @param [type] $data      [description]
     * 
     * @return [type]            [description]
     */
    public function modelContent($className,$data = null)
    {
        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        $content 
            = <<< EOT
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class $className extends Model
{
    protected \$table = "$tableName";
EOT;
        foreach ($this->fieldAttributesArray as $type) {
            $content .= $this->fieldAttributes($type, $data);
        }

        foreach ($this->relationships as  $type) {
            $content .= $this->relationships($type, $data);
        }

        $content .= "\n}";
        return $content;
    }

    /**
     * [fieldAttributes description]
     * 
     * @param [type] $type [description]
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function fieldAttributes($type,$data)
    {
        $content = "";
        $array = [];
        if (!is_null($data)) {
            foreach ($data as $item) {
                if (isset($item->$type) ) {
                    if (trim(strtolower($item->$type)) == "true") {
                        $array[] = $item->field;
                    }
                }
            }
        }
        $content = "\n protected \$$type = ['".join("','", $array)."'];";
        return $content;
    }

    /**
     * [relationships description]
     * 
     * @param [type] $type [description]
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function relationships($type,$data)
    {
        $content = "";
        foreach ($data as $field) {
            if (isset($field->$type)) {
                 $fieldName = str_replace("_id", "", $field->field);
                 $fieldName = str_replace('_', ' ', $fieldName);
                 $fieldName = ucwords($fieldName);
                 $func = lcfirst($fieldName);
                 $class = "App\\".str_replace(" ", "", $fieldName);
                    

                $content .= 
                <<< EOT


	public function $func() {
		return \$this->$type("$class");
	}

EOT;
            }
        }
        return $content;
    }


    /**
     * [migrationContent description]
     * 
     * @param [type] $name [description]
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function migrationContent($name,$data)
    {
        $tableName = strtolower($name);
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(" ", "", $name);
        $class = "Create".$name."Table";
        $up = $this->upContent($data);
        $down = $this->downContent($tableName);
        return $contnet  
            = <<< EOT
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class $class extends Migration
{
	public \$table = "$tableName";

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

    /**
     * [upContent description]
     * 
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function upContent($data)
    {
        $content = "";
        $content .= $this->createTable($data)."\n\t\t";
        $content .=  "else ".$this->modfiyTable($data);
        return $content;
    }

    /**
     * [createTable description]
     * 
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function createTable($data)
    {
        $content = " if (!Schema::hasTable(\$this->table)) {".
        "\n\t\t\tSchema::create(\$this->table, function (".
        "Blueprint \$table) {\n";
            
        foreach ($data as $field) {
            $content .= "\t".$this->migrationField($field);
        }
        $content .="\n\t\t\t\t\t\$table->timestamps();";

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

    /**
     * [modfiyTable description]
     * 
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function modfiyTable($data)
    {
        $content = " if (Schema::hasTable(\$this->table)) {"
        ."\n\t\t\tSchema::table(\$this->table, function ("
        ."Blueprint \$table) {\n";
            
        foreach ($data as $field) {
            $content .="\n\t\t\t\tif (!Schema::hasColumn(".
            "\$this->table, '".$field->field."')) {\n";
            $content .= "\t".$this->migrationField($field);
            $content .= "\n\t\t\t\t} else {\n";
            $content .= "\t".$this->migrationField($field, true);
            $content .= "\t\t\t\t}";
        }

        $content .= "\n\n\t\t\tif (!Schema::hasColumn(\$this->table, 'created_at')) {";
        $content .="\n\t\t\t\t\$table->timestamps();";
        $content .= "\n\t\t\t}";
        $content .= "\n\n\t\t\t\$sm = Schema::getConnection()->getDoctrineSchemaManager();\n";
        $content .= "\t\t\t\$indexesFound = \$sm->listTableIndexes(\$this->table);";

        $content .="\n\t\t\t//Indexes\n";
        foreach ($data as $field) {
            $content .= "\t".$this->migrationIndexes($field, true);
        }

        $content .="\n\t\t\t//foreign\n";
        foreach ($data as $field) {
            $content .= "\t".$this->migrationForeign($field, true);
        }

        $content .="\n\t\t\t//Dropped Columns\n";
        $content .= $this->migrationDropColumn($data);

        $content .="\n\t\t\t});";
        $content .="\n\t\t}";
        return $content;
    }
    /**
     * [downContent description]
     * 
     * @param [type] $tableName [description]
     * 
     * @return [type]            [description]
     */
    public function downContent($tableName)
    {
        $content = "\n\t\tSchema::dropIfExists('$tableName');";
        return $content;
    }

    /**
     * [migrationField description]
     * 
     * @param [type]  $field  [description]
     * @param boolean $change [description]
     * 
     * @return [type]          [description]
     */
    public function migrationField($field,$change = false)
    {
        $content = "";
        if (!isset($field->type)) {
            throw new Exception("Every line needs a type", 1);
        }
        if (strtolower($field->type) == "char" 
            || strtolower($field->type) == "string"
        ) {
            $content .= "\t\t\$table->".$field->type."('".
            $field->field."',".($field->length ?? 255).")";
        } else if (strtolower($field->type) == "decimal" 
            || strtolower($field->type) == "double" 
            || strtolower($field->type) == "float" 
            || strtolower($field->type) == "unsignedDecimal"
        ) {
            $content .= "\t\t\$table->".$field->type."('"
            .$field->field."',".$field->precision.","
            .$field->scale.")";
        } else if (strtolower($field->type) == "enum" 
            || strtolower($field->type) == "set"
        ) {
            $choices = "'".str_replace(",", "','", $field->choices)."'";
            $content .= "\t\t\$table->".$field->type
            ."('".$field->field."',[".$choices."])";
        } else {
                $content .= "\t\t\$table->".$field->type."('".$field->field."')";
        }
        foreach ([
            "first",
            "after",
            "useCurrent",
            "autoIncrement",
            "always",
            "nullable",
            "unsigned"
             ] as $func) {
            if (isset($field->$func) &&  strtolower($field->$func) == "true") {
                $content .="->$func()";
            } 
        }
        foreach ([
        "charset",
        "default",
        "storedAs",
        "virtualAs",
        "generatedAs"
            ] as $func) {
            if (isset($field->$func)) {
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
        if ($content != "") {
            if ($change === true) {
                $content .= "->change()";
            }
            return "\t\t".$content.";\n";
        }
        return $content;
    }

    public function migrationIndexes($field,$change = false)
    {
        $content = "";
        foreach (["primary","unique","index","spatialIndex"] as $func) {
            $wrapperStart = "";
            $wrapperStart .= "\n\t\t\tif(!array_key_exists(\$this->table.'_".
            $field->field.
            "_$func', \$indexesFound)){";

            $funcOut = "";
            if (isset($field->$func)) {
                $funcOut .= "\t\$table->$func('".$field->field."')";
                if ($change === true) {
                  $funcOut .= "->change()";
                }
                $funcOut .= ";";
            }   
                
            $wrapperEnd = "\n\t\t\t}";
            if (isset($field->$func)) {
                if($change === true){
                    $content = $wrapperStart.$funcOut.$wrapperEnd;
                } else{
                    $content = $funcOut;
                }
            }
        }
   
        return $content;
    }


    /**
     * [migrationForeign description]
     * 
     * @param [type]  $field  [description]
     * @param boolean $change [description]
     * 
     * @return [type]          [description]
     */
    public function migrationForeign($field,$change = false)
    {
        $content = "";
        $wrapperStart = "";
        $wrapperStart .= "\n\t\t\tif(!array_key_exists(\$this->table.'_".
        $field->field.
        "_foreign', \$indexesFound)){";

        if (isset($field->foreign)) {
            $func = "\n\t\t\t\t\$table->foreign('".
            $field->field."')->references('id')->on('".
            $field->foreign."')";
            if ($change === true) {
              $func .= "->change()";
            }
            $func .= ";";
        }
        
        $wrapperEnd = "\n\t\t\t}";
        if (isset($field->foreign)) {
            if($change === true){
                $content = $wrapperStart.$func.$wrapperEnd;
            } else{
                $content = $func;
            }
        }
   
        return $content;
    }

    /**
     * [migrationDropColumn description]
     * 
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function migrationDropColumn($data)
    {
        // $content .="\n\tif (Schema::hasColumn(\$this->table, '".
        // $key."')) {\n";
        // $content .= "\t\t\$table->dropColumn('".$key."');";
        // $content .= "\n\t}";
        $content = "";
        $syncDir = app_path()."\\database\\syncs\\";
        $syncDir =str_replace("/app", "", $syncDir);
        $syncDir =str_replace("\\app", "", $syncDir);
        $prev = scandir($syncDir);
        array_shift($prev);
        array_shift($prev);
        if(count($prev) > 0){
            $previousSync = $syncDir.end($prev);
        } else {
            $previousSync = null;
        }
        if (file_exists($previousSync)) {
            $last = file_get_contents($previousSync);
            if (trim($last) !== "") {
                $lastSyncData = json_decode($last);
                $item = reset($data);
                $entity = $item->entity;
                $field = $item->field;
                    
                foreach ($lastSyncData->$entity as $key => $needle) {
                    $check = $needle->field;
                    if(!isset($data[$check])){
                        $content .="\n\t\t\t\tif (Schema::hasColumn(\$this->table, '".
                        $key."')) {\n";
                        $content .= "\t\t\t\t\t\$table->dropColumn('".$needle->field."');";
                        $content .= "\n\t\t\t\t}";
                    }
                }
            }
        }
        return $content;
    }


    /**
     * [sheetData description]
     * 
     * @param [type] $client  [description]
     * @param string $sheetId [description]
     * @param string $sheet   [description]
     * @param string $ranges  [description]
     * 
     * @return [type]          [description]
     */
    public function sheetData($client, string $sheetId,
        string $sheet,$ranges = "A1:DF300"
    ) {
        $service = new \Google_Service_Sheets($client);
        if ($ranges == "header") {
            $response = $service->spreadsheets_values
                ->get($sheetId, $sheet."!A1:DF1");
            foreach ($response->values[0] as $i => $col) {
                $header[$i] = lcfirst($col);
            } 
            return $header;
        }
        $range = $sheet."!".$ranges;
        $response = $service->spreadsheets_values->get($sheetId, $range);
        foreach ($response->values[0] as $i => $col) {
                $header[$i] = lcfirst($col);
        } 
        unset($response->values[0]);
        $sheetData = [];
        foreach ($response->values as $row) {
            $obj = new \stdClass();
            foreach ($header as $pos => $name ) {
                if (!empty($row[$pos])) {
                    if ($name == "field") {
                        $row[$pos] = $this->fieldCase($row[$pos]);
                    }
                    $obj->$name = $row[$pos];
                }
            } 
            if (!empty((array) $obj)) {
                $sheetData[] = $obj;
            }
        } 
        return $sheetData;
    }

    /**
     * [fieldCase description]
     * 
     * @param [type] $fieldName [description]
     * @param string $type      [description]
     * 
     * @return [type]            [description]
     */
    public function fieldCase($fieldName,$type = "underscore")
    {
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        if ($type == "underscore") {
            $replace = '${1}_${2}';
            return strtolower(preg_replace($pattern, $replace, $fieldName));
        }
        if ($type == "camelCase") {
            $fieldName = ucwords(str_replace("_", " ", $fieldName));
            $fieldName = lcfirst(str_replace(" ", "", $fieldName));
            return $fieldName;
        }
    }

    /**
     * [defaultValueCheck description]
     * 
     * @param [type] $obj [description]
     * 
     * @return [type]      [description]
     */
    protected function defaultValueCheck($obj)
    {
        if (empty($obj->precision)) {
            $obj->precision = 10; 
        }
        if (empty($obj->scale)) { 
            $obj->scale = 0; 
        }
        if (empty($obj->options)) { 
            $obj->options = "false"; 
        }
        if (empty($obj->name)) { 
            $obj->name = $this->fieldCase($obj->field); 
        }
        if (empty($obj->referencedColumnName)) { 
            $obj->referencedColumnName =  "id"; 
        }
        if (empty($obj->description)) { 
            $obj->description = ""; 
        }
            return $obj;       
    }

    /**
     * [fieldDataFormat description]
     * 
     * @param [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function fieldDataFormat($data)
    {
        $output = [];
        foreach ($data as $field) {
            $output[$field->entity][$field->field] 
                = $this->defaultValueCheck($field);
        }
        return $output;
    }

    /**
     * [defaultformmeta description]
     * 
     * @param [type] $field [description]
     * 
     * @return [type]        [description]
     */
    protected function defaultformmeta($field)
    {
        $meta = [];
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        $replace = '${1} ${2}';
        $meta['label'] = ucfirst(preg_replace($pattern, $replace, $field->field));
        $meta['label'] = str_replace("_", " ", $meta['label']);
        $meta['sort'] = 999;
        $meta['key'] =  $this->fieldCase($field->field, "camelCase");
        $meta['data_type'] = $field->type;
        if ($field->type == "integer") {
            $meta['value'] = 0;
            $meta['type'] = "number";
        }
        if (in_array($field->type, ["array","ManyToMany","ManyToOne","OneToMany"])) {
            $meta['value'] = (array) [];
            $meta['type'] = "select";
        }
        if ($field->type == "text") {
            $meta['type'] = "textarea";
            $meta['source_view'] = false;
        }
        if ($field->type == "string") {
            $meta['type'] = "text";
        }
        if ($field->type == "datetime") {
            $meta['type'] = "datetime";
        }
        if ($field->type == "boolean") {
            $meta['type'] = "boolean";
        } else {
            $meta['value'] = (string) '';
        }
        return $meta;
    }

    /**
     * [formMetaBuild description]
     * 
     * @param object $field [description]
     * 
     * @return [type]        [description]
     */
    protected function formMetaBuild(object $field)
    {
        $meta = $this->defaultformmeta($field);
        if (!empty($field->choices)) {
            $choices = explode(",", $field->choices);
            foreach ($choices as $choice) {
                if (strpos($choice, ":")> 0) {
                    $choice = explode(":", $choice);
                    $meta['options'][$choice[0]] = $choice[1];
                } else {
                    $meta['options'][] = $choice;
                }
            }
        }
        if (!empty($field->targetEntity)) {
            $meta['options'] = [];
            $meta['target'] = $field->targetEntity;
        }

        foreach ($field as $attrKey => $attrVal) {
            if (in_array("formmeta", explode("_", $attrKey))) {
                $attrKey = (string) explode("formmeta", $attrKey)[1];
                $attrKey = trim($attrKey, "_"); 
                $meta[$attrKey] = (string) trim($attrVal);
                
                if ("true" == strtolower($attrVal) 
                    || "false" == strtolower($attrVal)
                ) {
                    $meta[$attrKey] = (strtolower($attrVal) == "true")
                     ? true : false;    
                } 
            }
        }
        if (!empty(trim($field->description))) {
            array_unshift($contents, "* ".$field->description);
        }
        return $meta;
    }

    /**
     * [listMetaBuild description]
     * 
     * @param object $field [description]
     * 
     * @return [type]        [description]
     */
    protected function listMetaBuild(object $field)
    {
        $meta = [];
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        $replace = '${1} ${2}';
        $meta['label'] = ucfirst(preg_replace($pattern, $replace, $field->field));
        $meta['label'] = str_replace("_", " ", $meta['label']);
        $meta['key'] =  $this->fieldCase($field->field, "camelCase");
        $meta['data_type'] = $field->type;
        if (!empty($field->targetEntity)) {
            $meta['options'] = [];
            $meta['target'] = $field->targetEntity;
        }
        foreach ($field as $attrKey => $attrVal) {
            if (in_array("tableMeta", explode("_", $attrKey))) {
                $attrKey = (string) explode("tableMeta", $attrKey)[1];
                $attrKey = trim($attrKey, "_"); 
                $meta[$attrKey] = (string) trim($attrVal);
                if ("true" == strtolower($attrVal) 
                    || "false" == strtolower($attrVal)
                ) {
                    $meta[$attrKey] = (
                        strtolower($attrVal) == "true"
                    ) ? true : false;    
                } 
            }
        }
        if (!empty(trim($field->description))) {
            array_unshift($contents, "* ".$field->description);
        }
        return $meta;
    }
}