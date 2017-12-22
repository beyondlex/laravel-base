<?php
/**
 * Created by PhpStorm.
 * User: doudou
 * Date: 2017/12/6
 * Time: 20:04
 */

namespace App\Services;

use App\Criterias\ClientCriteria;
use App\Exceptions\Traits\ClientTrait;
use App\Repositories\SignInRepository;
use App\Models\SignIn;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SignInService
{
	use ClientTrait;

	private $signInRepository;
	private $fileService;

    public function __construct(SignInRepository $signInRepository, FileService $fileService)
    {
        $this->signInRepository = $signInRepository;
        $this->fileService = $fileService;
    }

    function create($data) {

		$file = $this->fileService->store('signin');

		$signIn = new SignIn();
		$signIn->client_id = $this->getClientId();
		$signIn->sign_in_time = date('Y-m-d H:i:s');
		if ($file) $signIn->file_id = $file->id;
		$signIn->fill($data);
		$signIn->save();

		return $this->signInRepository->parserResult($signIn);
	}

	function paginate($perPage) {
		$perPage = $perPage ?? 5;
		$data = $this->signInRepository
			->pushCriteria(new ClientCriteria($this->getClientId()))->paginate($perPage);
		return $data;
	}

	function find($id) {
    	return $this->signInRepository->pushCriteria(new ClientCriteria($this->getClientId()))->find($id);
	}

	function update($id, $data) {
    	/** @var SignIn $signIn */
    	$signIn = $this->signInRepository->skipPresenter()->find($id);
    	if ($signIn->client_id != $this->getClientId()) {
    		throw new NotFoundHttpException('Resource not found.');
		}
    	$signIn->fill($data);
    	$signIn->save();
    	return $signIn->presenter();
	}

}