<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function recordExists($id,$passive = false){
        $model = $this->getModel()->find($id);
        if(is_null($model)){
            return false;
        }
        return true;
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

}
