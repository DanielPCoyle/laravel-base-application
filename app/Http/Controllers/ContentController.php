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

class ContentController extends Controller
{
   public function upload(Request $request)
   {
    $data = [];
    if($request->isMethod('post')){
      $path = $request->file('file')->store('testing');
      return response()->json(['path' => $path], 200);
    }
  }
  
  public function download($file, Request $request)
  {
    $filePath = storage_path('app/'.$file);
    if(file_exists($filePath)){
      return response()->download($filePath);
    }
    return response()->json([
      "status"=>"fail",
      "event"=>"download_fail",
      "message"=> "File '$file' does not exists in this system"],
      404);
  }
}