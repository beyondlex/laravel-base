<?php
/**
 * Created by PhpStorm.
 * User: doudou
 * Date: 2017/12/6
 * Time: 20:03
 */

namespace App\Repositories;

use App\SignIn;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Presenter\ModelFractalPresenter;

class SignInRepository extends Repository
{
	public function boot()
	{
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function presenter()
	{
		return ModelFractalPresenter::class;
	}

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return SignIn::class;
	}
}