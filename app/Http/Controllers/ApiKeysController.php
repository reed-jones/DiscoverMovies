<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiKeysController extends Controller
{
    //
    public function index(){
    	$apis = \App\ApiKey::all();
        
        // return view('welcome', compact('apis'));
        return view('welcome')->with('apis', $apis);
    }
}
