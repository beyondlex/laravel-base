<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/18
 * Time: 上午10:45
 */

namespace App\Repositories;

use App\Files;

class FileRepository extends Repository {

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Files::class;
	}
}