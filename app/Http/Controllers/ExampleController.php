<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Test
 * @Resource("Test", uri="/example")
 * @package App\Http\Controllers
 */
class ExampleController extends Controller
{
    public function __construct()
    {
//        $this->middleware('client_credentials');
        $this->middleware('api_auth');
    }

    /**
     * Just for test
     * @Get("/test")
     * @Response(200)
     * @return string
     */
    function test() {
        return 'hi';
    }
}
