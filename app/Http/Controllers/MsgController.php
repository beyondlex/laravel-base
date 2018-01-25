<?php

namespace App\Http\Controllers;

use App\Mail\CommonMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MsgController extends Controller
{
    //
	protected $request;

	public function __construct(Request $request)
	{
		parent::__construct();
		$this->request = $request;
		$this->middleware('client_credentials');
	}

	function sendMail() {
		$request = $this->request;
		$body = $request->post('body');
		$to = $request->post('to');
		$subject = $request->post('subject');
		$rules = [
			'body'=>'required',
			'to'=>'required',
			'subject'=>'required',
		];

		$this->validate($this->request, $rules);

//		return $subject;

		Mail::to($to)->queue((new CommonMail($body))->subject($subject));


	}
}
