<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataPrivacyController extends Controller
{
    public function index(){
        return view("dataprivacy");
    }
}
