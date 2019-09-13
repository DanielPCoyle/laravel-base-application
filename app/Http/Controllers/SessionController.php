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

class SessionController extends Controller
{
    public function setSession($variable,Request $request){
        $request->session()->put($variable,"TESTING");
        return response()->json($request->session()->get($variable));
    } 

    public function getSession($variable,Request $request){
        $return = $request->session()->has($variable) ?  $request->session()->get($variable) : null;
        return response()->json($return);
    }
}