<?php

namespace App\Http\Controllers;

use App\ApiKey;
use Illuminate\Http\Request;

class ApiKeysController extends Controller
{
    public function index(){
        return view('welcome')
            ->with('apis', ApiKey::all());
    }
}
