<?php

namespace App\Http\Controllers;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validate(Request $request, array $rules,
							 array $messages = [], array $customAttributes = [])
	{
		$validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
		if ($validator->fails()) {
			throw new ResourceException('Bad Request', $validator->errors());
		}
	}
}
