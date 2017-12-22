<?php

namespace App;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
	use UuidForKey;
	use SoftDeletes;

	protected $fillable = [
		'name', 'code'
	];
}
