<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/19
 * Time: 下午8:46
 */

namespace App\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ClientCriteria implements CriteriaInterface {

	private $clientId;
	public function __construct($clientId)
	{
		$this->clientId = $clientId;
	}

	/**
	 * Apply criteria in query repository
	 *
	 * @param                     $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		return $model->where('client_id', '=', $this->clientId);

	}
}