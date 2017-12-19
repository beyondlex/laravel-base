<?php

namespace App\Http\Controllers;

use App;
use App\Services\SignInService;
use Illuminate\Http\Request;

class SignInController extends Controller
{
	private $sign_in;
	private $request;
    public function __construct(Request $request, SignInService $sign_in)
    {
    	parent::__construct();
        $this->sign_in = $sign_in;
        $this->request = $request;
		$this->middleware('client_credentials');
    }

    public function signIn(){

        $rules = [
        	'sign_in_type'=>'required',
		];
        $this->validate($this->request, $rules);
        return $this->sign_in->create($this->request->all());
    }

    public function getSignInList(){
        return $this->sign_in->paginate($this->request->get('perPage'));
    }

    public function getSignInInfo($id){
        return $this->sign_in->find($id);
    }

    public function updateSignInInfo($id){
        return $this->sign_in->update($id, $this->request->all());
    }
}
