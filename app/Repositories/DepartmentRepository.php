<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Repositories;


use App\Models\Department;

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

	public function createChild(Department $parent, $childData) {
		return $parent->children()->create($childData);
	}

	public function tree() {
		$department = $this->skipPresenter()->get(['id', 'parent_id', 'name', 'lft', 'rgt']);
		return $department->toTree();

	}
}