<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Repositories;


use App\Models\Company;
use Prettus\Repository\Presenter\ModelFractalPresenter;

class CompanyRepository extends Repository
{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Company::class;
	}

	public function presenter()
	{
		return ModelFractalPresenter::class;
	}
}