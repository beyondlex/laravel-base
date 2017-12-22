<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Repositories;


use App\Department;
use Prettus\Repository\Presenter\ModelFractalPresenter;

class DepartmentRepository extends Repository
{


	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Department::class;
	}

	public function presenter()
	{
		return ModelFractalPresenter::class;
	}

	public function createChild(Department $parent, $childData) {
		return $parent->children()->create($childData);
	}

	public function tree() {
		$department = $this->skipPresenter()->get(['id', 'parent_id', 'name', 'lft', 'rgt']);
		return $department->toTree();

	}
}