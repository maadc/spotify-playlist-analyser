<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function key(){
        $key = "test";

        return response($key, 200);
    }
}
