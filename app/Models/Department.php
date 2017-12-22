<?php

namespace App\Models;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

class Department extends Model implements Transformable, Presentable
{
    //
	use NodeTrait;
	use UuidForKey;
	use PresentableTrait;
	use SoftDeletes;

	protected $fillable = [
		'name', 'parent_id', 'company_id',
	];


	function getLftName()
	{
		return 'lft';
	}
	function getRgtName()
	{
		return 'rgt';
	}

	/**
	 * @return array
	 */
	public function transform()
	{
		return [
			'name'=>$this->name,
			'parent_id'=>$this->parent_id,
			'company_id'=>$this->company_id,
		];
	}
}
