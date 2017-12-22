<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $request;
    private $company;

	public function __construct(Request $request, CompanyService $company)
	{
		parent::__construct();
		$this->request = $request;
		$this->company = $company;
	}

	function all() {
		return $this->company->all();
	}
	function create() {
		return $this->company->create($this->request->all());
	}
	function find($id) {
		return $this->company->find($id);
	}
	function update($id) {
		return $this->company->update($id, $this->request->all());
	}
	function delete($id) {
		if ($this->company->delete($id)) {
			return response('deleted', 204);
		}
	}
}
