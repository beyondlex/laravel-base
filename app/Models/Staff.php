<?php

namespace App\Models;



use App\Extensions\Traits\ImageTrait;

/**
 * @property mixed department_id
 * @property mixed id
 * @property mixed company_id
 * @property mixed role_id
 * @property mixed phone
 * @property mixed email
 * @property mixed last_login
 * @property mixed password
 * @property mixed confirm_password
 * @property mixed status
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed send_sms
 * @property mixed face_tokens
 * @property mixed face_status
 */
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
