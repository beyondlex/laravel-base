<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Services;


use App\Repositories\LevelRepository;
use App\Repositories\RoleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleService
{

	private $repository;
	public function __construct(RoleRepository $repository)
	{
		$this->repository = $repository;
	}

	function all() {
		return $this->repository->all();
	}

	function paginate($perPage) {
		$perPage = $perPage ?? 5;
		$data = $this->repository->paginate($perPage);
		return $data;
	}

	function find($id) {
		return $this->repository->find($id);
	}

	function create($data) {
		return $this->repository->create($data);
	}

	function update($id, $data) {
		$model = $this->repository->skipPresenter()->find($id);
		$model->fill($data);
		$model->save();

		return $this->repository->parserResult($model);
	}

	function delete($id) {
		return $this->repository->delete($id);
	}
}