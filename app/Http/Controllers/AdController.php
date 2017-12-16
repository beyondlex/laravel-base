<?php

namespace App\Http\Controllers;

use App\Services\AdService;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

		$this->validate($this->request, $rules);

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
