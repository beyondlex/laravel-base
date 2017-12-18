<?php

namespace App\Http\Controllers;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
	{
		$request = app('request');
		$bearerToken=$request->bearerToken();
		$tokenId= (new Parser())->parse($bearerToken)->getHeader('jti');
		$client = Token::find($tokenId)->client;

		\App::singleton('curato', function() use ($client) {
			$curato = new \stdClass();
			$curato->client = $client;
			return $curato;
		});
	}

	public function validate(Request $request, array $rules,
							 array $messages = [], array $customAttributes = [])
	{
		$validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
		if ($validator->fails()) {
			throw new ResourceException('Bad Request', $validator->errors());
		}
	}
}
