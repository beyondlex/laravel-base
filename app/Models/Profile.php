<?php

namespace App\Models;


/**
 * @property mixed id
 * @property mixed staff_id
 * @property mixed name
 * @property mixed gender
 * @property mixed telephone
 * @property mixed telephone_ext
 * @property mixed address
 * @property mixed remark
 * @property mixed avatar
 * @property mixed visible
 */
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
