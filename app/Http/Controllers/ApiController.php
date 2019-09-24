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


//TODO: Write test validation.
class ApiController extends Controller
{
    use DispatchesJobs, ValidatesRequests;
    private $query;
    public function __construct(Request $request, Guard $auth){
        $path = explode("/",trim($request->getPathInfo(),"/"));
        $this->query = isset($path[1]) ?  new QueryService($request,$path[1])   : null;
    }

    public function get($entity,$id = null, Request $request){
        if(method_exists($this, $id)){
            return $this->$id($entity, $request);
        }
        if($this->query->getModel() === false){
           return response()->json([
        "status"=>"fail",
        "event"=>"create_failure",
        "entity"=>$entity,
        "message"=> "$entity do not exists in this system"],
        404);
        }

        $assoc = [];
        if($request->query("assoc") == 1){
            $fillable = $this->query->getModel()->getFillable();
            $classMethods = get_class_methods($this->query->getModel());
            foreach ($fillable as $key => $value) {
                $check = trim($value,"_id");
                if(in_array($check,$classMethods) === true){
                    $assoc[] = $check;
                }
            }
        }
        if($id !== null){
            $recordCheck = $this->query->recordExistsCheck($id); 
            if($recordCheck !== true){
                return $recordCheck;
            } 
            $result = $this->query->getModel()->find($id);
            $transformer = "\App\Http\Resources\\".explode("\\",$this->query->tableToClass($entity))[1];
            if(class_exists($transformer)){
                $result = new $transformer($result);
            }
            return response()->json($result,200);
        }

        if(!empty($request->all())){           
            $this->query->fields();
            $this->query->where("where");
            $this->query->where("orWhere");
        }

        if($request->input("format")){
            $methodName = $request->input("format")."Format";
            if(method_exists($this->query, $methodName)){
                return $this->query->$methodName($this->query->result($assoc)->data);
            }
        }
        $result = $this->query->result($assoc);
        return response()->json($result,200);
    } 

    public function post($entity,Request $request){
        $data = $request->all();
        if(!is_array( json_decode( $request->getContent() ) ) ){
            $data = [$data];
        }

        $created = [];
        foreach ($data as $item) {
            $new = $this->query->getModel()->create($item);
            if(is_null($new->id)){
                return response()->json([
                    "status"=>"fail",
                    "event"=>"create_failure",
                    "entity"=>$entity,
                    "message"=> "There was an error creating $entity"],
                    404);
            }
            $created[] = $new->id;
        }

        if(count($data) == 1){
            return response()->json([
                "status"=>"success",
                "event"=>"create_success",
                "entity"=>$entity,
                "data"=>$new],
                200);
        }

        return response()->json([
            "status"=>"success",
            "event"=>"multi_post_success",
            "entity"=>$this->query->entity,
            "data"=>["created"=>$created]],
            200);   
    }

    public function put($entity,$id = null,Request $request){
        dd($request);
        $data = $this->query->dataSetUp($id,$request);
        $updated = [];
        foreach ($data as $item) {
            $passId = ($id > 0) ? $id : $item['id'];
            $recordCheck = $this->query->recordExistsCheck($passId);
            if($recordCheck !== true){
                return $recordCheck;
            }
            $model = $this->query->getModel()->find($passId)
            ->fill($item);
            $model->save();
            $updated[] = $passId;
        }

        if(count($data) == 1){
            return response()->json([
                "status"=>"success",
                "event"=>"update_success",
                "entity"=>$entity,
                "data"=>$model],
                200);
        }

        return response()->json([
            "status"=>"success",
            "event"=>"update_multi_success",
            "entity"=>$entity,
            "data"=>["updated" =>$updated]
        ],
        200);
    }

    public function set($entity,$field, $value, $id = null, Request $request){
        $data = $this->query->dataSetUp($id,$request);
        $columnCheck = $this->query->columnCheck($entity,$field);
        if($columnCheck !== true){
            return $columnCheck;
        }
        $updated = [];
        foreach ($data as $item) { 
            $passId = is_numeric($item) ? $item : $item['id'];       
            $recordCheck = $this->query->recordExistsCheck($passId);
            if($recordCheck !== true){
                return $recordCheck;
            }
            $model = $this->query->getModel()->find($passId);
            $model->$field = $value;
            $model->save();
            $updated[] = $passId;
        }
        if(count($data) == 1){        
            return response()->json([
                "status"=>"success",
                "event"=>"set_success",
                "entity"=>$entity,
                "data"=>$model],
                200);
        } else{
            return response()->json([
                "status"=>"success",
                "event"=>"set_multi_success",
                "entity"=>$entity,
                "data"=>['updated'=>$updated]],
                200);
        }
    } 

    public function delete($entity,$id = null, Request $request){
        $data = $this->query->dataSetUp($id,$request);
        $deleted = [];
        foreach($data as $dId){
            $recordCheck = $this->query->recordExistsCheck($dId); 
            if($recordCheck !== true){
                return $recordCheck;
            }
            $model = $this->query->getModel()->find($dId)->delete();
            $deleted[] = $dId;
        }
        if(count($data) == 1){
            return response()->json([
                "status"=>"success",
                "event"=>"delete_success",
                "entity"=>$entity,
                "id"=>$id],
                200);
        }
        return response()->json([
            "status"=>"success",
            "event"=>"delete_success",
            "entity"=>$entity,
            "data"=> ["deleted" => $deleted]],
            200);

    }

    public function math($entity,$field,$math,$id = null, Request $request){
        $math = explode(",",$math);
        $data = $this->query->dataSetUp($id,$request);
        $updated = [];
        foreach ($data as $item) {
            $passId = is_numeric($item) ? $item : $item['id'];       
            $item = $this->query->getModel()->find($passId);
            $validMathCheck = $this->query->validMathCheck($item->$field,$math);
            if($validMathCheck !== true){
                return $validMathCheck;
            }
            $operator = str_replace("d","/",$math[0]);
            $value = $math[1];
            $result = $item->$field.$operator.$value;
            $result = eval('return '.$result.';');
            $result = $this->set($entity,$field, $result, $passId, $request);
            $updated[] = $passId;
        }

        if(count($data) == 1){        
            return response()->json([
                "status"=>"success",
                "event"=>"set_success",
                "entity"=>$entity,
                "data"=>$result->getData()],
                200);
        } else{
            return response()->json([
                "status"=>"success",
                "event"=>"set_multi_success",
                "entity"=>$entity,
                "data"=>['updated'=>$updated]],
                200);
        }
    }

    public function form_fields($entity,Request $request){
        $fields = [];
        $settings = $this->query->getModel()->getFillable(); //Making use of Eloquent
        $columns = DB::getDoctrineSchemaManager()
            ->listTableDetails($entity);
        foreach ($settings as $key => $value) {
            $fields[$value] = json_decode($columns->getColumn($value)->getComment())->form ?? null;
        }
        if(json_decode($request->input("render"))){
            return view("test",["fields" => $fields, "entity" => $entity]);
        }
        return response()->json($fields,200);
    }

    public function list_fields($entity,Request $request){
        $fields = [];
        $settings = $this->query->getModel()->getFillable(); //Making use of Eloquent
        $columns = DB::getDoctrineSchemaManager()
            ->listTableDetails($entity);
        foreach ($settings as $key => $value) {
            $fields[$value] = json_decode($columns->getColumn($value)->getComment())->list ?? null;
        }
        return response()->json($fields,200);
    }
}