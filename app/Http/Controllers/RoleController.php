<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\DepartmentService;
use App\Services\LevelService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $request;
    private $service;

	public function __construct(Request $request, RoleService $service)
	{
		parent::__construct();
		$this->request = $request;
		$this->service = $service;
	}

	function all() {
		return $this->service->paginate($this->request->get('perPage'));
	}
	function create() {
		$data = $this->request->only(['name', 'company_id', 'level_id']);

		return $this->service->create($data);
	}
	function find($id) {
		return $this->service->find($id);
	}
	function update($id) {
		return $this->service->update($id, $this->request->all());
	}
	function delete($id) {
		if ($this->service->delete($id)) {
			return response('deleted', 204);
		}
	}
}
