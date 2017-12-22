<?php

namespace App\Models;



use App\Extensions\Traits\ImageTrait;

class Staff extends BaseModel
{
	use ImageTrait;
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
			'avatar'=>$this->profile->avatar ? $this->originalUrl($this->profile->avatar) : '',
			'avatar_s'=>$this->profile->avatar ? $this->thumbUrl($this->profile->avatar) : '',
		];
	}
}
