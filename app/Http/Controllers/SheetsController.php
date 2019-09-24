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
use App\Http\Services\SheetsService;

class SheetsController extends Controller
{

	private $sheets;
	public function __construct(){
		$this->sheets = new SheetsService;
	}

	public function do(){
		$client = $this->getGoogleClient();
		if(env('PROJECT_SHEET_ID') !== null){
			return response()->json("PROJECT_SHEET_ID not defined in enviorment file");
		}
		$data = $this->sheets->sheetData($client,env('PROJECT_SHEET_ID'),"Fields");
		$data = $this->sheets->fieldDataFormat($data);
		$output = "";
		$lastSync = app_path()."/database/lastSheetSync.json";
		$lastSync =str_replace("/app", "", $lastSync);
		$lastSync =str_replace("\\app", "", $lastSync);
		if(file_exists($lastSync)){
			$lastSyncData = file_get_contents($lastSync);
			if(trim($lastSyncData) !== ""){
				$lastSyncData = json_decode($lastSyncData);
				foreach ($lastSyncData as $entity => $value) {
					if(!isset($data[$entity])){
						$this->deleteMigrationFile($entity);
						$this->deleteModelFile($entity);
					}
				}
			}
		}
		foreach ($data as $entity => $field) {
			$this->writeMigrationFile($entity,$field);
			$output .= "\n $entity Migration File Created";
			$this->writeModelFile($entity,$field);
			$output .= "\n $entity Model File Created";
		}

		$output .= "\n Sync has finished, ".count($data)." tables updated or created";
		$h = fopen($lastSync, "w");
		fwrite($h, json_encode($data));
		fclose($h);

		echo $output;
	}

  function getGoogleClient()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Sheet Sites');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS,\Google_Service_Drive::DRIVE]);
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
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
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
	
	public function deleteMigrationFile($entity){
		$path = app_path();
		$path =str_replace("/app", "", $path);
		$path =str_replace("\\app", "", $path);
		$path = $path."\\database\\migrations\\";
		$file = "create_".strtolower($entity)."_table.php";
		foreach (scandir($path) as $f) {
			if(strpos($f, $file) > -1){
				unlink($path.$f);
			}
		}
	}
	public function deleteModelFile($entity){
		$path = app_path()."\\".$entity.".php";
		if(file_exists($path)){
			unlink($path);
		}
	}

	public function writeMigrationFile($name = "test",$data){
		$fileWoTime = "create_".strtolower($name)."_table.php";
		$fileName = date("Y_m_d_his")."_".$fileWoTime;
		$path = app_path();
		$path =str_replace("/app", "", $path);
		$path =str_replace("\\app", "", $path);
		$path = $path."/database/migrations/";
		$filePath = $path.$fileName;
		foreach (scandir($path) as $key => $value) {
			$fileName = explode("_",$value);
			$fileName = array_slice($fileName,4);
			if(join("_",$fileName) == $fileWoTime){
				unlink($path.$value);
			}
		}
		$h = fopen($filePath, "w");
		fwrite($h, $this->sheets->migrationContent($name,$data));
		fclose($h);
	}

	public function writeModelFile($name,$data){
		$path = app_path()."/$name.php";
		$h = fopen($path, "w");
		fwrite($h, $this->sheets->modelContent($name,$data));
		fclose($h);
	}
}

