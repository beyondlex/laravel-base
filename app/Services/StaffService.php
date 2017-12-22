<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/21
 * Time: 下午10:31
 */

namespace App\Services;


use App\Models\Staff;
use App\Repositories\StaffRepository;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

class StaffService
{

	private $repository;
	private $profile;
	private $fileService;
	public function __construct(StaffRepository $repository,
								ProfileService $profile, FileService $fileService)
	{
		$this->repository = $repository;
		$this->profile = $profile;
		$this->fileService = $fileService;
	}

	function all() {
		return $this->repository->all();
	}

	function paginate($perPage) {
		$perPage = $perPage ?? 5;
		$data = $this->repository->paginate($perPage);
		return $data;
	}

	function find($id) {
		return $this->repository->find($id);
	}

	function create($data) {

		$data['password'] = md5($data['password']);

		/** @var Staff $staff */
		$staff = $this->repository->skipPresenter()->create($data);

		if ($staff) {
			$data['staff_id'] = $staff->id;

			$avatar = $this->fileService->store('avatar', 'public', 'avatar');
			if ($avatar) {
				$data['avatar'] = $avatar->url;
			}

			$profile = $this->profile->create($data);
			if ($profile) {
				return $staff->presenter();
			}
			//todo
		}

		return new StoreResourceFailedException('Operation failed.');

	}

	function update($id, $data) {
		$staff = $this->repository->skipPresenter()->find($id);

		if ($this->profile->update($staff->profile->id, $data)) {
			return $this->repository->skipPresenter(false)->update($data, $id);
		} else {
			throw new UpdateResourceFailedException('Update failed');
		}
	}

	function delete($id) {
		return $this->repository->delete($id);
	}
}