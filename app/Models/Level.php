<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

class Level extends BaseModel
{
    //
	use NodeTrait;

	protected $fillable = [
		'name', 'company_id', 'parent_id', 'readonly',
	];

	function getLftName()
	{
		return 'lft';
	}

	function getRgtName()
	{
		return 'rgt';
	}

	function transform()
	{
		return [
			'id'=>$this->id,
			'company_id'=>$this->company_id,
			'parent_id'=>$this->parent_id,
			'name'=>$this->name,
			'readonly'=>$this->readonly,

		];
	}

}
