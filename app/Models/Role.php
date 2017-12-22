<?php

namespace App\Models;


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
