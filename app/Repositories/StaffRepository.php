<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Repositories;


use App\Models\Staff;

class StaffRepository extends Repository
{


	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Staff::class;
	}

}