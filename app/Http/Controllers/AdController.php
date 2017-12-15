<?php

namespace App\Http\Controllers;

use App\Services\AdService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    private $ad;
    private $request;

    public function __construct(AdService $ad, Request $request)
    {
        $this->ad = $ad;
        $this->request = $request;
    }

    function all() {
        return $this->ad->all();
    }

    function one($id) {
        return $this->ad->find($id);
    }

    function create() {

        $ad = $this->request->get('ad');

        return $this->ad->create($ad);
    }
}
