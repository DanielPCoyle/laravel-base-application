<?php

namespace App\Http\Controllers;

use App\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\QueryService;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $query;

    public function __construct(Request $request){
        $path = explode("/",trim($request->getPathInfo(),"/"));
        $this->query = new QueryService($request,$path[1]);
    }

    public function get($entity,Request $request, $render = true)
    {
        if(!empty($request->all())){           
           $this->query->fields();
           $this->query->where("where");
           $this->query->where("orWhere");
       }

       if($request->input("format")){
        $methodName = $request->input("format")."Format";
        if(method_exists($this->query, $methodName)){
            return $this->query->$methodName($this->query->result()->data);
        }
       }

       return response()->json($this->query->result(),200);
   } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSingle($entity,$id, Request $request)
    {
        if($this->query->recordExists($id)){
            $entity = $this->query->fields($request, $entity)->where("id",$id)->first();
            return response()->json($entity,200);
        } else{
            return response()->json(["event"=>"get","entity"=>$entity,"id"=>$id,"message"=>"$entity with the id #$id does not exists"],404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post($entity,Request $request)
    {
        $model = $this->query->getModel();
        $create = $model->create($request->input());
        if(is_null($create->id)){
            return response()->json(["event"=>"create_failure","entity"=>$entity,"message"=> "There was an error creating $entity"],404);
        }
        return response()->json(["event"=>"create_success","entity"=>$entity,"id"=>$create->id],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bases  $bases
     * @return \Illuminate\Http\Response
     */
    public function put($entity,$id,Request $request)
    {
        if($this->query->recordExists($id)){
            $model = $this->query->getModel()->find($id);
            $model->fill($request->input());
            $model->save();
            return response()->json(["event"=>"update_failure","entity"=>$entity,"id"=>$id],200);
        } else{
            return response()->json(["event"=>"update_success","entity"=>$entity,"id"=>$id,"message"=>"$entity with the id #$id does not exists"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bases  $bases
     * @return \Illuminate\Http\Response
     */
    public function delete($entity,$id)
    {
        if($this->query->recordExists($id)){
            $model = $this->query->getModel()->find($id)->delete();
            return response()->json(["event"=>"delete_success","entity"=>$entity,"id"=>$id],200);
        } else{
            return response()->json(["event"=>"delete_failure","entity"=>$entity,"id"=>$id,"message"=>"$entity with the id #$id does not exists"],404);
        }
    }

    public function test($entity){
        $csv_data = $this->query->getModel()->get();
    }

}