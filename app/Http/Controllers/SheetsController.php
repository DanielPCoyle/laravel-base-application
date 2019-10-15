<?php
/**
 * 
 */
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
use App\Http\Services\SheetsService;
use Artisan;

/**
 * The sheets controller is used 
 * to execute sheets commands in the console.
 */
class SheetsController extends Controller
{

	protected $sheets;

    /**
     * [__construct description]
     */
    public function __construct()
    {
    	$this->sheets = new SheetsService;
        $this->timestamp = date("Y_m_d_his")."_";
    }

    /**
     * [do description]
     * 
     * @return [type] [description]
     */
    public function do($rollback = null,$force = false)
    {
        if(app()->env == "production"){
            dd('You must be in a development or testing enviorment to sync with your project sheet.');
        }
    	$client = $this->getGoogleClient();
    	$lastSyncData = "";
    	if (env('PROJECT_SHEET_ID') === null) {
    		return response()->json(
    			["error"=> 
    			"PROJECT_SHEET_ID not defined in enviorment file"
    		]
    	);
    	}
    	$syncDir = app_path()."\\database\\syncs\\";
    	$syncDir =str_replace("/app", "", $syncDir);
    	$syncDir =str_replace("\\app", "", $syncDir);
    	$timestamp = $this->timestamp;
    	$currentSync = $syncDir.$timestamp."SheetSync.json";
    	$prev = scandir($syncDir);
    	array_shift($prev);
    	array_shift($prev);
    	if(count($prev) > 0){
    		$previousSync = $syncDir.end($prev);
    	} else {
    		$previousSync = null;
    	}
    	if ($rollback !== null) {
    		$data = json_decode(file_get_contents($syncDir.$rollback));
    	} else {
    		$data = $this->sheets->sheetData($client, env('PROJECT_SHEET_ID'), "Fields");
    		$data = $this->sheets->fieldDataFormat($data);
    	}
        
        if ($previousSync !== null) {
        	$lastSyncData = file_get_contents($previousSync);
        	if (trim($lastSyncData) !== "") {
        		$lastSyncData = json_decode($lastSyncData);
        	}
    		if((json_encode($data) !== json_encode($lastSyncData)) || $force === true){
    			foreach ($lastSyncData as $entity => $value) {
    				if ((is_array($data) && !isset($data[$entity])) || !isset($data->$entity) ) {
    					$this->deleteMigrationFile($entity);
    					$this->deleteModelFile($entity);
    					$this->deleteFactoryFile($entity);
    				}
    			}

    			foreach ($data as $entity => $field) {
    				$this->writeMigrationFile($entity, $field);
    				$this->writeModelFile($entity, $field);
    				$this->writeFactoryFile($entity, $field);
    			}
    		}
    	}

    	$output = "Sync has finished,";
    	if(is_null($rollback)){
    		if((json_encode($data) !== json_encode($lastSyncData)) || $force === true){
    			$h = fopen($currentSync, "w");
    			fwrite($h, json_encode($data));
    			fclose($h);
    			$output .= count((array) $data).
    			" tables updated or created";
                Artisan::call('migrate', ["--force"=> true ]);
                $output .="\n".Artisan::output();
    		} else {
    			$output .= "No changes made.";
    		}
    	}
    	return $output;
    }

    /**
     * [getGoogleClient description]
     * 
     * @return [type] [description]
     */
    private function getGoogleClient()
    {
    	$client = new \Google_Client();
    	$client->setApplicationName('Sheet Sites');
    	$client->setScopes(
    		[\Google_Service_Sheets::SPREADSHEETS,\Google_Service_Drive::DRIVE]
    	);
    	$dir = app_path();
    	$dir =str_replace("/app", "", $dir);
    	$dir =str_replace("\\app", "", $dir);
    	$credFile = $dir.'/credentials.json';
    	$client->setAuthConfig($credFile);
    	$client->setAccessType('offline');
    	$client->setPrompt('select_account consent');

    	$tokenPath = $dir.'/token.json';
    	if (file_exists($tokenPath)) {
    		$accessToken = json_decode(file_get_contents($tokenPath), true);
    		$client->setAccessToken($accessToken);
    	}

    	if ($client->isAccessTokenExpired()) {
    		if ($client->getRefreshToken()) {
    			$client->fetchAccessTokenWithRefreshToken(
    				$client->getRefreshToken()
    			);
    		} else {
    			$authUrl = $client->createAuthUrl();
    			printf("Open the following link in your browser:\n%s\n", $authUrl);
    			print 'Enterv erification code: ';
    			$authCode = trim(fgets(trim(fopen('php://stdin', 'r'))));
    			$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    			$client->setAccessToken($accessToken);

    			if (array_key_exists('error', $accessToken)) {
    				throw new Exception(join(', ', $accessToken));
    			}
    		}
    		if (!file_exists(dirname($tokenPath))) {
    			mkdir(dirname($tokenPath), 0700, true);
    		}
    		file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    	}
    	return $client;
    }
    

    public function fakerParse($value){
    	if(strpos(trim($value), "faker") !== false){
    		$value = "\$".$value;
    	}
    	return $value;
    }

    public function writeFactoryFile($entity,$data){
    	$arrayOutput = "";
    	foreach ($data as $value) {
    		if(isset($value->factory)){
    			$arrayOutput .= '"'.$value->field.'" => '.$this->fakerParse($value->factory);
    			$arrayOutput .= ",\n\t\t";

    		}
    	}
    	if($arrayOutput == ""){
    		return false;
    	}
    	$content = <<< EOT
<?php

/** @var \Illuminate\Database\Eloquent\Factory \$factory */

use App\\$entity;
use Faker\Generator as Faker;

\$factory->define($entity::class, function (Faker \$faker) {
	return [
		$arrayOutput
	];
});
EOT;

    		$factoryFile = app_path()."\\database\\factories\\$entity.php";
    		$factoryFile =str_replace("/app", "", $factoryFile);
    		$factoryFile =str_replace("\\app", "", $factoryFile);
    		$h = fopen($factoryFile , "w");
    		fwrite($h,$content);
    		fclose($h);

    	}
    /**
     * [deleteMigrationFile description]
     * 
     * @param  [type] $entity [description]
     * 
     * @return [type]         [description]
     */
    public function deleteMigrationFile($entity)
    {
    	$path = app_path();
    	$path =str_replace("/app", "", $path);
    	$path =str_replace("\\app", "", $path);
    	$path = $path."\\database\\migrations\\";
    	$file = "create_".strtolower($entity)."_table.php";
    	foreach (scandir($path) as $f) {
    		if(strpos($f, $file) > -1) {
    			unlink($path.$f);
    		}
    	}
    }

    /**
     * [deleteModelFile description]
     * 
     * @param  [type] $entity [description]
     * 
     * @return [type]         [description]
     */
    public function deleteModelFile($entity)
    {
    	$path = app_path()."\\".$entity.".php";
    	if(file_exists($path)) {
    		unlink($path);
    	}
    }
    /**
     * [deleteModelFile description]
     * 
     * @param  [type] $entity [description]
     * 
     * @return [type]         [description]
     */
    public function deleteFactoryFile($entity)
    {
    	$path = app_path()."\\".$entity.".php";
    	$path =str_replace("/app", "", $path);
    	$path =str_replace("\\app", "", $path);
    	$path = $path."\\database\\factories\\";
    	if(file_exists($path)) {
    		unlink($path);
    	}
    }

    /**
     * [writeMigrationFile description]
     * 
     * @param  string $name [description]
     * @param  [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function writeMigrationFile($name = "test",$data)
    {
    	$fileWoTime = "create_".strtolower($name)."_table.php";
    	$fileName = $this->timestamp.$fileWoTime;
    	$path = app_path();
    	$path =str_replace("/app", "", $path);
    	$path =str_replace("\\app", "", $path);
    	$path = $path."/database/migrations/";
    	$filePath = $path.$fileName;
    	foreach (scandir($path) as $key => $value) {
    		$fileName = explode("_", $value);
    		$fileName = array_slice($fileName, 4);
    		if(join("_", $fileName) == $fileWoTime) {
    			unlink($path.$value);
    		}
    	}
    	$h = fopen($filePath, "w");
    	fwrite($h, $this->sheets->migrationContent($name, $data));
    	fclose($h);
    }

    /**
     * [writeModelFile description]
     * 
     * @param  [type] $name [description]
     * @param  [type] $data [description]
     * 
     * @return [type]       [description]
     */
    public function writeModelFile($name,$data)
    {
    	$path = app_path()."/$name.php";
    	$h = fopen($path, "w");
    	fwrite($h, $this->sheets->modelContent($name, $data));
    	fclose($h);
    }
}

