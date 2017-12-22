<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

class Department extends BaseModel
{
    //
	use NodeTrait;

	protected $fillable = [
		'name', 'parent_id', 'company_id',
	];


	function getLftName()
	{
		return 'lft';
	}
	function getRgtName()
	{
		return 'rgt';
	}

	/**
	 * @return array
	 */
	public function transform()
	{
		return [
			'name'=>$this->name,
			'parent_id'=>$this->parent_id,
			'company_id'=>$this->company_id,
		];
	}
}
