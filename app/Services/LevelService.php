<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Services;


use App\Repositories\LevelRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LevelService
{

	private $repository;
	public function __construct(LevelRepository $repository)
	{
		$this->repository = $repository;
	}

	function all() {
		return $this->repository->tree();
//		return $this->repository->all();
	}

	function find($id) {
		return $this->repository->find($id);
	}

	function create($data) {

		if (isset($data['parent_id']) && $data['parent_id']) {
			$parent = $this->repository->skipPresenter()->find($data['parent_id']);
			if (!$parent) throw new NotFoundHttpException('Resource not found.');
			return $this->repository->createChild($parent, $data);
		}
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