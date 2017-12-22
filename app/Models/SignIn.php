<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed file_id
 * @property mixed sign_in_time
 * @property mixed sign_in_type
 * @property mixed address
 * @property mixed position
 * @property mixed content
 * @property mixed remark
 * @property mixed client_id
 */
class SignIn extends Model implements Transformable, Presentable
{
	use PresentableTrait;
    protected $table = 'sign_in';
    protected $primaryKey = 'id';
    protected $fillable = ['client_id', 'user_id', 'sign_in_time',
		'sign_in_type','address','position','content','file_id','remark'];

	/**
	 * @return array
	 */
	public function transform()
	{
		return [
			'id'=>$this->id,
			'user_id'=>$this->user_id,
			'file_id'=>$this->file_id,
			'sign_in_time'=>$this->sign_in_time,
			'sign_in_type'=>$this->sign_in_type,
			'address'=>$this->address,
			'position'=>$this->position,
			'content'=>$this->content,
			'remark'=>$this->remark,
		];
	}
}
