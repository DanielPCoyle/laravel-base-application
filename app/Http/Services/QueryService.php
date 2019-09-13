<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class QueryService 
{
    public $request;
    public $entity;
    public $model;

    public function __construct(Request $request, $entity){
        $this->request = $request;
        $model = $this->tableToClass($entity);
        $this->model = new $model();
    }

    public function where($func){
        $whereArray = [];
        if(empty($this->request->query(strtolower($func)))){
            return $this->model;
        }
        $where = $this->request->query(strtolower($func));
        foreach ($where as $key => $value) {
            $value = explode(",", $value);
            if(count($value) == 2){
                $whereArray[] = [$key,$value[0],$value[1]];
            } else{
                $whereArray[] = [$key,"=",$value[0]];
            }
        }
        $this->model = $this->model->$func($whereArray);
        return $this->model;
    }

    public function fields(){
        $fields = ["*"];
        if($this->request->query("fields")){
            $fields = explode(",",$this->request->query("fields"));
            $this->model = $this->model->select($fields);
        }
        return $this->model;
    }

    public function pagination(){
        return $this->model->paginate($this->request->query("limit"));
    }

    public function result(){
        $result = new \StdClass();
        $result->data = $this->model->get();
        if($this->request->query("limit")){
            $result->pagination = $this->pagination();
        }
        return $result;
    }

    public function dataSetUp($id,$request){
        $data = $request->all();
        if($id === null){
            if(!is_array( json_decode( $request->getContent() ) ) ){
                $data = [$data];
            }
        } else{
            if(strpos($id,",") === false){
                $data = [$id];
            } else{
                $data = explode(",",$id);
            }
        }
        return $data;
    }


    public function getModel(){
        return $this->model;
    }

    public function tableToClass($string, $capitalizeFirstCharacter = true) 
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        $str = explode(".",$str)[0];
        return "App\\".$str;
    }

    public function csvFormat($csv_data){
        $response = response()->streamDownload(
            function () use ($csv_data) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, array_keys($csv_data[0]->getAttributes()));
                foreach ($csv_data as $row) {
                    fputcsv($handle, $row->getAttributes());
                }
                fclose($handle);
            },
            $this->entity."_".date("D-M-d_Y-G-i").".csv",
            [ //Headers
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=members.csv'
            ]
        );
        return $response;
    }

    public function recordExistsCheck($id,$passive = false){
        $model = $this->getModel()->find($id);
        if(is_null($model)){
             return response()->json(["event"=>"set_success",
            "entity"=>$this->entity,
            "id"=>$id,
            "message"=>$this->entity." with the id #$id does not exists"],
            404);
        }
        return true;
    }

    public function columnCheck($entity,$field){
        if (Schema::hasColumn($entity, $field) == false){
            return response()->json(["event"=>"set_failure",
            "entity"=>$entity,
            "message"=>"Field '$field' does not exist on $entity"],
            404);
        }
        return true;
    }

    public function validMathCheck($field,$math){
        $operator = str_replace("d","/",$math[0]);
        $validMath = false;
        if(is_numeric($field) == false){
            return response()->json(["event"=>"math_failure",
            "entity"=>$this->entity,
            "message"=>"$field of ".$this->entity." is not a number"],
            404);
        }
       if(count($math) <= 2 && is_numeric($math[1]) == false ){
            return response()->json(["event"=>"math_failure",
            "entity"=>$this->entity,
            "message"=>"Please include a math operator and number seperated by a comma in the math paramter"],
            404);   
        }
        foreach(["*","d","+","-"] as $check){
            if(strpos($operator, $check) !== false){
                $validMath = true;
            }
        }
        if($validMath == false){
            return response()->json([
                "event"=>"math_failure",
                "entity"=>$this->entity,
                "message"=>"A valid operator was not defined"],
                404);
        }

        $roundError = true;
        if(count($math) > 2){
            $rounder = $math[2];
            if(strtolower($rounder) == "ru"){
                $roundError = false;
            }
            if(strtolower($rounder) == "rd"){
                $roundError = false;
            }
            if($roundError == true){
                return response()->json([
                "event"=>"math_failure",
                "entity"=>$this->entity,
                "message"=>"When using the round parameter, please include 'ru' for rounding up or 'rd' for rounding down"],
                404);
            }
        }
        return true;
    }
}
