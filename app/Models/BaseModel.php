<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/22
 * Time: 下午2:20
 */
namespace App\Models;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @property mixed deleted_at
 * @property mixed updated_at
 * @property mixed created_at
 */
class BaseModel extends Model implements Transformable , Presentable {


	use UuidForKey;
	use PresentableTrait;
	use SoftDeletes;

	/**
	 * @return array
	 */
	public function transform()
	{
		// TODO: Implement transform() method.
		return [
			'id'=>$this->getKey(),
		];

	}
}