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

    	//@todo validator
        $data = $this->request->get('ad');

        return $this->ad->create($data);
    }

    function update($id) {

    	return $this->ad->update($id, $this->request->get('ad'));
	}
}
