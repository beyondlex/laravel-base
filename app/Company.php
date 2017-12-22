<?php

namespace App;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

class Company extends Model implements Transformable, Presentable
{
    //
	use UuidForKey;
	use SoftDeletes;
	use PresentableTrait;

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
