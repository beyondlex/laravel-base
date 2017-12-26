<?php

namespace App\Models;


/**
 * @property mixed id
 * @property mixed name
 * @property mixed company_id
 * @property mixed level_id
 * @property false|string created_at
 * @property false|string deleted_at
 */
class Role extends BaseModel
{
    //

	protected $fillable = [
		'name', 'company_id', 'level_id',
	];

	function transform()
	{
		return [
			'id'=>$this->id,
			'name'=>$this->name,
			'company_id'=>$this->company_id,
			'level_id'=>$this->level_id,
		];
	}
}
