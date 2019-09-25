<?php

namespace App\Http\Controllers;

use App\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function setSession($variable =null , $value = null, Request $request)
    {
        if($variable) {
            $request->session()->put($variable, $value);
        } else{
            dump($request);
        }
        return response()->json($request->session()->all());
    } 

    public function getSession($variable = null,Request $request)
    {
        if($variable) {
            $return = $request->session()->has($variable) ?  $request->session()->get($variable) : null;
        } else{
            $return = $request->session()->all();
        }
        return response()->json($return);
    }
}
