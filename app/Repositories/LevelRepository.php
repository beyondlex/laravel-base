<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Repositories;


use App\Models\Level;

class LevelRepository extends Repository
{


	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Level::class;
	}

	public function createChild(Level $parent, $childData) {
		return $parent->children()->create($childData);
	}

	public function tree() {
		$level = $this->skipPresenter()->get(['id', 'parent_id', 'name', 'lft', 'rgt']);
		return $level->toTree();

	}
}