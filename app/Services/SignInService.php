<?php
/**
 * Created by PhpStorm.
 * User: doudou
 * Date: 2017/12/6
 * Time: 20:04
 */

namespace App\Services;

use App\Repositories\SignInRepository;
use App\SignIn;

class SignInService
{
	private $signInRepository;
	private $fileService;
    public function __construct(SignInRepository $signInRepository, FileService $fileService)
    {
        $this->signInRepository = $signInRepository;
        $this->fileService = $fileService;
    }

    function create($data) {

		$curato = app('curato');
		$client = $curato->client;

		$file = $this->fileService->store('signin');

		$signIn = new SignIn();
		$signIn->client_id = $client->id;
		$signIn->sign_in_time = date('Y-m-d H:i:s');
		if ($file) $signIn->file_id = $file->id;
		$signIn->fill($data);
		$signIn->save();

		return $this->signInRepository->parserResult($signIn);
	}

	function paginate($perPage) {
		$perPage = $perPage ?? 5;
		$data = $this->signInRepository->paginate($perPage);
		return $data;
	}

	function find($id) {
    	return $this->signInRepository->find($id);
	}

	function update($id, $data) {
    	/** @var SignIn $signIn */
    	$signIn = $this->signInRepository->skipPresenter()->find($id);
    	$signIn->fill($data);
    	$signIn->save();
    	return $signIn->presenter();
	}

}