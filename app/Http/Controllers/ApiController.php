<?php
/**
 * ApiController File.
 * php version 7.2.10
 * 
 * @category API
 * @author   Dan Coyle <dancoyle89@gmail.com>
 */
namespace App\Http\Controllers;
use App\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\QueryService;
use App\Http\Services\Custom\GetService;
use App\Http\Services\Custom\PostService;
use App\Http\Services\Custom\PutService;
use App\Http\Services\Custom\DeleteService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

/**
 * The ApiController class holds 
 * the logic for the api routes 
 * (the routes prefixed with "/api/").
 * 
 * @category API
 */
class ApiController extends Controller
{
    //TODO: Write test validation.
    use DispatchesJobs, ValidatesRequests;
    protected $query;
    protected $custom;
    protected $getService;
    protected $postService;
    protected $putService;
    protected $deleteService;

    /**
     * [__construct description]
     *
     * @param Request $request The HTTP request
     * @param Guard   $auth    Illuminate\Contracts\Auth\Guard
     */
    public function __construct(Request $request, Guard $auth)
    {
        $path = explode("/", trim($request->getPathInfo(), "/"));
        $this->query = isset($path[1]) ?  
        new QueryService($request, $path[1]) : null;
        if (is_null($this->query)) {
            return response()->json(
                ["error"=>"Error setting query Service"],
                301
            );
        }
        $this->getService = new GetService();
        $this->postService = new PostService();
        $this->putService = new PutService();
        $this->deleteService = new DeleteService();
    }
    /**
     * Retrieve entity record(s).
     * Endpoint: /api/{entity}/
     * Endpoint with Filters: /api/{entity}?filters...
     * 
     * @param [type]  $entity  The name of the database table
     * @param Request $request The HTTP request
     * @param [type]  $id      The entity record number
     * 
     * @return [type]           [description]
     */
    public function get($instance = null, $entity, Request $request, $id = null)
    {

        $className = explode("\\",$this->query->tableToClass($entity));
        $customMethod = lcfirst(end($className));
        if($instance !== null){
            $instanceClassMethod = lcfirst($instance).ucfirst($customMethod); 
            if (method_exists($this->getService, $instanceClassMethod) ) {
                return $this->getService->$instanceClassMethod($entity, $request);
            }
        }

        if (method_exists($this->getService, $customMethod) ) {
            return $this->getService->$customMethod($entity, $request);
        }
        if ($this->query->getModel() === false) {
            return response()->json(
                [
                "status"=>"fail",
                "event"=>"create_failure",
                "entity"=>$entity,
                "message"=> "$entity do not exists in this system"],
                404
            );
        }
        $assoc = [];
        if ($request->query("assoc") == 1) {
            $fillable = $this->query->getModel()->getFillable();
            $classMethods = get_class_methods($this->query->getModel());
            foreach ($fillable as $key => $value) {
                $check = trim($value, "_id");
                if (in_array($check, $classMethods) === true) {
                    $assoc[] = $check;
                }
            }
        }
        if ($id !== null) {
            $recordCheck = $this->query->recordExistsCheck($id); 
            if ($recordCheck !== true) {
                return $recordCheck;
            } 
            $result = $this->query->getModel()->find($id);
            $transformer = "\App\Http\Resources\\".
            explode("\\", $this->query->tableToClass($entity))[1];
            if (class_exists($transformer)) {
                $result = new $transformer($result);
            }
            return response()->json([
            "status" => "success",
            "entity" => $entity,
            "event" => "get_success",
            "data"=>$result], 200);
        }
        if (!empty($request->all())) {           
            $this->query->fields();
            $this->query->where("where");
            $this->query->where("orWhere");
        }
        if ($request->input("format")) {
            $methodName = $request->input("format")."Format";
            if (method_exists($this->query, $methodName)) {
                return $this->query->$methodName($this->query->result($assoc)->data);
            }
        }
        $result = $this->query->result($assoc);
        return response()->json([
            "status" => "success",
            "entity" => $entity,
            "event" => "get_success",
            "data"=>$result], 200);
    } 

    /**
     * Create a new entity record. 
     * 
     * @param string  $entity  The name of the database table
     * @param Request $request The HTTP request
     * 
     * @return object           The results of the post request
     */
    public function post($instance = null, $entity,Request $request)
    {
        $className = explode("\\",$this->query->tableToClass($entity));
        $customMethod = ucfirst(end($className));
        if (method_exists($this->postService, $customMethod) ) {
            return $this->postService->$customMethod($entity, $request);
        }

        $data = $request->all();
        if (!is_array(json_decode($request->getContent())) ) {
            $data = [$data];
        }
        $created = [];
        foreach ($data as $item) {
            $new = $this->query->getModel()->create($item);
            if (is_null($new->id)) {
                return response()->json(
                    [
                    "status"=>"fail",
                    "event"=>"create_failure",
                    "entity"=>$entity,
                    "message"=> "There was an error creating $entity"],
                    404
                );
            }
            $created[] = $new->id;
        }
        if (count($data) == 1) {
            return response()->json(
                [
                "status"=>"success",
                "event"=>"create_success",
                "entity"=>$entity,
                "data"=>$new],
                200
            );
        }
        return response()->json(
            [
            "status"=>"success",
            "event"=>"multi_post_success",
            "entity"=>$this->query->entity,
            "data"=>["created"=>$created]],
            200
        );   
    }

    /**
     * Update a specific entity record.
     * 
     * @param string  $entity  The name of the database table
     * @param Request $request The HTTP request
     * @param integer  $id      The entity record number
     * 
     * @return [type]           [description]
     */
    public function put($instance = null, $entity,Request $request,$id = null)
    {
        $className = explode("\\",$this->query->tableToClass($entity));
        $customMethod = ucfirst(end($className));
        if (method_exists($this->putService, $customMethod) ) {
            return $this->putService->$customMethod($entity, $request);
        }
        $model = $this->query->getModel()->find($id);
        $model->update($request->all());

        // if (count($data) == 1) {
        //     return response()->json(
        //         [
        //         "status"=>"success",
        //         "event"=>"update_success",
        //         "entity"=>$entity,
        //         "data"=>$model],
        //         200
        //     );
        // }
        return response()->json(
            [
            "status"=>"success",
            "event"=>"update_multi_success",
            "entity"=>$entity,
            "data"=>["data" =>$model]
            ],
            200
        );
    }

    /**
     * Set values to specific fields on specific records
     * 
     * @param [type]  $entity  The name of the database table
     * @param [type]  $field   The name of the property of the you are updating. 
     * @param [type]  $value   The data to update with.
     * @param Request $request The HTTP request
     * @param [type]  $id      the entity record number.
     *
     * @return [type] [<description>]
     */
    public function set($instance = null, $entity,$field, $value, Request $request,$id = null)
    {
        $className = explode("\\",$this->query->tableToClass($entity));
        $customMethod = "set".ucfirst(end($className));
        if (method_exists($this->custom, $customMethod) ) {
            return $this->custom->$customMethod($entity, $request);
        }
        $data = $this->query->dataSetUp($id, $request);
        $columnCheck = $this->query->columnCheck($entity, $field);
        if ($columnCheck !== true) {
            return $columnCheck;
        }
        $updated = [];
        foreach ($data as $item) { 
            $passId = is_numeric($item) ? $item : $item['id'];       
            $recordCheck = $this->query->recordExistsCheck($passId);
            if ($recordCheck !== true) {
                return $recordCheck;
            }
            $model = $this->query->getModel()->find($passId);
            $model->$field = $value;
            $model->save();
            $updated[] = $passId;
        }
        if (count($data) == 1) {        
            return response()->json(
                [
                "status"=>"success",
                "event"=>"set_success",
                "entity"=>$entity,
                "data"=>$model],
                200
            );
        } 
        return response()->json(
            [
            "status"=>"success",
            "event"=>"set_multi_success",
            "entity"=>$entity,
            "data"=>['updated'=>$updated]],
            200
        );
    } 
    /**
     * Deletes records from data base
     * 
     * @param [type]  $entity  The name of the database table
     * @param Request $request The HTTP request
     * @param [type]  $id      The entity record number
     * 
     * @return [type]           [description]
     */
    public function delete($instance = null, $entity, Request $request,$id = null)
    {
        $className = explode("\\",$this->query->tableToClass($entity));
        $customMethod = ucfirst(end($className));
        if (method_exists($this->deleteService, $customMethod) ) {
            return $this->deleteService->$customMethod($entity, $request);
        }
        $data = $this->query->dataSetUp($id, $request);
        $deleted = [];
        foreach ($data as $dId) {
            $recordCheck = $this->query->recordExistsCheck($dId); 
            if ($recordCheck !== true) {
                return $recordCheck;
            }
            $model = $this->query->getModel()->find($dId)->delete();
            $deleted[] = $dId;
        }
        if (count($data) == 1) {
            return response()->json(
                [
                "status"=>"success",
                "event"=>"delete_success",
                "entity"=>$entity,
                "id"=>$id],
                200
            );
        }
        return response()->json(
            [
            "status"=>"success",
            "event"=>"delete_success",
            "entity"=>$entity,
            "data"=> ["deleted" => $deleted]],
            200
        );
    }

    /**
     * Used to perform basic math operations via a request.
     * 
     * @param [type] $entity  The name of the database table
     * @param [type] $field   [description]
     * @param [type] $request The HTTP request
     * @param [type] $id      The entity record number
     * 
     * @return [type]          [description]
     */
    public function math($instance = null, $entity,$field,$math, Request $request,$id = null)
    {
        $math = explode(",", $math);
        $data = $this->query->dataSetUp($id, $request);
        $updated = [];
        foreach ($data as $item) {
            $passId = is_numeric($item) ? $item : $item['id'];       
            $item = $this->query->getModel()->find($passId);
            $validMathCheck = $this->query->validMathCheck($item->$field, $math);
            if ($validMathCheck !== true) {
                return $validMathCheck;
            }
            $operator = str_replace("d", "/", $math[0]);
            $value = $math[1];
            $result = $item->$field.$operator.$value;
            $result = eval('return '.$result.';');
            $result = $this->set($entity, $field, $result, $passId, $request);
            $updated[] = $passId;
        }
        if (count($data) == 1) {        
            return response()->json(
                [
                "status"=>"success",
                "event"=>"set_success",
                "entity"=>$entity,
                "data"=>$result->getData()],
                200
            );
        } else {
            return response()->json(
                [
                "status"=>"success",
                "event"=>"set_multi_success",
                "entity"=>$entity,
                "data"=>['updated'=>$updated]],
                200
            );
        }
    }
    /**
     * Returns meta data for form rendering
     * 
     * @param string  $entity  Name of model or database table.
     * @param Request $request The HTTP request
     * 
     * @return string          json_array
     */
    public function meta($instance = null, $entity,$type, Request $request)
    {
        $model = $this->query->getModel();
        $meta = $model->getMeta($type);
        if($request->input("fields")){
            $fields = explode(",",$request->input("fields"));
            foreach ($meta as $key => $value) {
                if(!in_array($key, $fields)){
                    unset($meta->$key);
                }
            }
        }

        if (json_decode($request->input("render"))) {
            $view = view(
                "form_meta", 
                ["fields" => $meta, 
                    "entity" => $entity]
            );
            return $view;
        }

        return response()->json([
                "status"=>"success",
                "entity"=>$entity,
                "event"=>"get_list_meta",
                "data" =>$meta,
            ], 200);
    }

    public function fixtures($instance = null, $entity,$count = 1){
        if(app()->env !== "development"){
            return response()->json('You must be in a development enviorment to sync with your project sheet.');
        }
        $entity = $this->query->tableToClass($entity);
        $class = get_class($this->query->getModel());

        $result = factory($class, (Integer) $count)->create();
        return response()->json(
            [
            "status" => "success",
            "event" => "fixtures_created",
            "data" => $result,
            ],200);
    }
}
