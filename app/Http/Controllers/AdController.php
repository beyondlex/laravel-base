<?php

namespace App\Http\Controllers;

use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdController extends Controller
{
    private $ad;
    private $request;

    public function __construct(AdService $ad, Request $request)
    {
    	parent::__construct();

        $this->ad = $ad;
        $this->request = $request;
		$this->middleware('client_credentials')->only(['create', 'update', 'delete']);
    }

    function all() {
        return $this->ad->paginate(Input::get('perPage'));
    }

    function one($id) {
        return $this->ad->find($id);
    }

    function create() {
		$rules = [
			'duration'=>'required',
			'file'=>'required',
			's_time'=>'date',
			'e_time'=>'date|after:s_time',
		];

		$this->validate($this->request, $rules);

        $data = $this->request->only(['duration', 's_time', 'e_time']);

        return $this->ad->create($data);
    }

    function update($id) {

    	return $this->ad->update($id, $this->request->only(['duration']));
	}

	function delete($id) {
		if ($this->ad->delete($id)) {
			return response('Deleted.', 204);
		}
	}
}
