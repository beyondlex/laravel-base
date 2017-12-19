<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/11
 * Time: 上午9:52
 */

namespace App\Repositories;


use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Validator\Contracts\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class Repository extends BaseRepository
{

	/**
	 * Find data by id
	 *
	 * @param       $id
	 * @param array $columns
	 *
	 * @return mixed
	 */
	public function find($id, $columns = ['*'])
	{
		$this->applyCriteria();
		$this->applyScope();
		$model = $this->model->find($id, $columns);
		if (!$model) {
			throw new NotFoundHttpException('Resource not found.');
		}
		$this->resetModel();

		return $this->parserResult($model);
	}

	/**
	 * Update a entity in repository by id
	 *
	 * @throws ValidatorException
	 *
	 * @param array $attributes
	 * @param       $id
	 *
	 * @return mixed
	 */
	public function update(array $attributes, $id)
	{
		$this->applyScope();

		if (!is_null($this->validator)) {
			// we should pass data that has been casts by the model
			// to make sure data type are same because validator may need to use
			// this data to compare with data that fetch from database.
			$attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

			$this->validator->with($attributes)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
		}

		$temporarySkipPresenter = $this->skipPresenter;

		$this->skipPresenter(true);

		$model = $this->model->find($id);
		if (!$model) {
			throw new NotFoundHttpException('Resource not found');
		}
		$model->fill($attributes);
		$model->save();

		$this->skipPresenter($temporarySkipPresenter);
		$this->resetModel();

		event(new RepositoryEntityUpdated($this, $model));

		return $this->parserResult($model);
	}
}