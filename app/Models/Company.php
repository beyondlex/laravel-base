<?php

namespace App\Models;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * @property mixed id
 * @property mixed pid
 * @property mixed name
 * @property mixed code
 * @property mixed phone
 * @property mixed address
 * @property mixed logo
 * @property mixed area_code
 * @property mixed province
 * @property mixed city
 * @property mixed district
 * @property mixed contact_name
 * @property mixed contact_phone
 * @property mixed contact_gender
 * @property mixed contact_role
 * @property mixed contact_email
 * @property mixed status
 * @property mixed scale
 * @property mixed industry
 * @property mixed reg_from
 * @property mixed reg_by
 * @property mixed channel
 * @property mixed sales_email
 * @property mixed deleted_at
 * @property mixed created_at
 *
 */
class Company extends BaseModel
{
    //

	protected $fillable = [
		'name', 'code'
	];

	/**
	 * @return array
	 */
	public function transform()
	{
		return [
			'id'=>$this->id,
			'name'=>$this->name,
			'code'=>$this->code,

		];
	}
}
