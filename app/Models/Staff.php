<?php

namespace App\Models;


class Staff extends BaseModel
{
    //
	protected $fillable = [
		'department_id', 'company_id', 'role_id',
		'phone', 'email', 'password', 'confirm_password',
		'status', 'last_login',
	];

	function profile() {
		return self::hasOne(Profile::class);
	}

	function transform()
	{
		return [
			'id'=>$this->id,
			'company_id'=>$this->company_id,
			'department_id'=>$this->department_id,
			'role_id'=>$this->role_id,
			'phone'=>$this->phone,
			'email'=>$this->email,
			'last_login'=>$this->last_login,
			'name'=>$this->profile->name,
		];
	}
}
