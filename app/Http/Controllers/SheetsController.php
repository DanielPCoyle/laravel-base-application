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

	public function do($file = "test"){
		$this->writeMigrationFile($file);
		$this->writeModelFile($file);
	}
	

	public function writeMigrationFile($name = "test"){
		$fileName = date("Y_m_d_his")."_".$name.".php";
		$path = app_path();
		$path =str_replace("/app", "", $path);
		$path = $path."/database/migrations/".$fileName;
		$h = fopen($path, "w");
		$data = new \StdClass();
		fwrite($h, $this->sheets->migrationContent($name,$data));
		fclose($h);
	}

	public function writeModelFile($name = "test"){
		$path = app_path()."/$name.php";
		$h = fopen($path, "w");
		$data = new \StdClass();
		$data->belongsTo = ["user_id"];
		fwrite($h, $this->sheets->modelContent("ABC",$data));
		fclose($h);
	}

}

