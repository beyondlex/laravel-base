<?php

namespace App;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed filename
 * @property mixed url
 */
class Files extends Model
{
    use UuidForKey;
    //

	protected $fillable = [
		'filename', 'type', 'size', 'url',
	];

}
