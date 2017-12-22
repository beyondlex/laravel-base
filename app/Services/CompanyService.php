<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Services;


use App\Repositories\CompanyRepository;

class CompanyService
{

	private $company;
	public function __construct(CompanyRepository $company)
	{
		$this->company = $company;
	}

	function all() {
		return $this->company->all();
	}

	function paginate($perPage) {
		$perPage = $perPage ?? 5;
		$data = $this->company->paginate($perPage);
		return $data;
	}

	function find($id) {
		return $this->company->find($id);
	}

	function create($data) {
		return $this->company->create($data);
	}

	function update($id, $data) {
		$company = $this->company->skipPresenter()->find($id);
		$company->fill($data);
		$company->save();

		return $this->company->parserResult($company);
	}

	function delete($id) {
		return $this->company->delete($id);
	}
}