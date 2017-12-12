<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('client_credentials');
//        $this->middleware('api_auth');
    }
    function test() {
        return 'hi';
    }
}
