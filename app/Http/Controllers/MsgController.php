<?php

namespace App\Http\Controllers;

use App\Mail\CommonMail;
use Illuminate\Http\JsonResponse;
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

		try {
			Mail::to($to)->send((new CommonMail($body))->subject($subject));

		} catch (\Swift_SwiftException $e) {
			throw $e;
			return new JsonResponse('email server error.', 500);
		}

//		Mail::to($to)->queue((new CommonMail($body))->subject($subject));
		return response('ok', 200);
	}
}
