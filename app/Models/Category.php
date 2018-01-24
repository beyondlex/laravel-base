<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Lex\Mongotree\TreeTrait;

/**
 * @property string name
 * @property int|mixed depth
 * @property mixed|string path
 * @property mixed id
 */
class Category extends Model
{
    //
	use TreeTrait;
	protected $connection = 'mongodb';

	protected $fillable = [
		'name', 'parent_id'
	];

//	public function createSub($name) {
//		$sub =  new self();
//		$sub->name = $name;
//		$sub->depth = $this->depth + 1;
//		$sub->path = $this->path ? ($this->path . ':' . $this->id ) : $this->id;
//		$sub->save();
//		return $sub->id;
//	}
}
