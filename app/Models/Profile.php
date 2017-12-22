<?php

namespace App\Models;


class Profile extends BaseModel
{
    //
	protected $fillable = [
		'staff_id', 'name', 'avatar',
	];

	function transform()
	{
		return [
			'id'=>$this->id,
			'staff_id'=>$this->staff_id,
			'name'=>$this->name,
		];
	}
}
