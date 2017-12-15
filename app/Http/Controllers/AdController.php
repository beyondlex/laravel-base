<?php

namespace App\Http\Controllers;

use App\Services\AdService;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
		$rules = [
			'ad.duration'=>'required',
		];
		$messages = [
			'ad.duration.required'=>'duration required',
		];
    	$validator = Validator::make($this->request->all(), $rules, $messages);
    	if ($validator->fails()) {
    		throw new StoreResourceFailedException('bad req', $validator->errors());
		}

        $data = $this->request->get('ad');

        return $this->ad->create($data);
    }

    function update($id) {

    	return $this->ad->update($id, $this->request->get('ad'));
	}

	function delete($id) {
		if ($this->ad->delete($id)) {
			return response('Deleted.', 204);
		}
	}
}
