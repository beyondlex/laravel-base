<?php

namespace App\Http\Controllers;

use App\Services\FaceService;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Http\Request;

class FaceController extends Controller
{

	private $request;
	private $faceService;

	public function __construct(Request $request, FaceService $faceService)
	{
		parent::__construct();
		$this->request = $request;
		$this->faceService = $faceService;
		$this->middleware('client_credentials');
	}

	/**
	 * 创建人脸库
	 * @return bool|mixed
	 */
	function createFaceSet() {
		$rules = [
			'id'=>'required',
			'display_name'=>'required',
		];
		$this->validate($this->request, $rules);
		$id = $this->request->get('id');
		$displayName = $this->request->get('display_name');

		$outerId = $this->faceService->getOuterId($id);

		return $this->faceService->faceSetCreate($displayName, $outerId);
	}

	/**
	 * 删除人脸库
	 * @param $id
	 * @return bool|mixed
	 */
	function deleteFaceSet($id) {
		$outerId = $this->faceService->getOuterId($id);
		return $this->faceService->faceSetDelete($outerId);
	}

	/**
	 * 人脸库详情
	 * @param $id
	 * @return bool|mixed
	 */
	function faceSet($id) {
		$outerId = $this->faceService->getOuterId($id);
		return $this->faceService->faceSet($outerId);
	}

	/**
	 * 录入人脸数据
	 * @param $id
	 * @return bool|mixed
	 */
	function addFace($id) {

		$rules = [
			'user_id'=>'required',
			'url'=>'required_without:file',
			'file'=>'required_without:url',
		];

		$this->validate($this->request, $rules);

		$outerId = $this->faceService->getOuterId($id);

		$file = $this->request->file('file');
		$url = $this->request->get('url');
		$userId = $this->request->get('user_id');

		if ($url) {
			return $this->faceService->faceSetAddFace($url, $outerId, $userId);
		} else {
			return $this->faceService->faceSetAddFaceWithFile($file->getRealPath(), $outerId, $userId);
		}
	}

	/**
	 * 抹除人脸数据
	 * @param $id
	 * @param $faceToken
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	function removeFace($id, $faceToken) {

		$outerId = $this->faceService->getOuterId($id, $faceToken);
		$resp = $this->faceService->faceSetRemoveFace($outerId, $faceToken);
		if (isset($resp['face_removed']) && $resp['face_removed']) {
			return response('removed', 204);
		}
		throw new ResourceException('failed');
	}

	/**
	 * 人脸匹配
	 * @param $id
	 * @return array
	 */
	function searchFace($id) {

		$rules = [
			'url'=>'required_without:file',
			'file'=>'required_without:url',
		];

		$this->validate($this->request, $rules);

		$outerId = $this->faceService->getOuterId($id);
		$url = $this->request->get('url');
		$file = $this->request->file('file');
		if ($url) {
			$resp = $this->faceService->search($url, $outerId);
		} else {
			$resp = $this->faceService->searchWithFile($file->getRealPath(), $outerId);
		}
		if (empty($resp['results']) or $resp['results'][0]['confidence'] < 80) {
			throw new ResourceException('Face not found.');
		}
		return [
			'user_id'=>$resp['results'][0]['user_id']
		];

	}
}
