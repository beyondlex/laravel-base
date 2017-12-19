<?php
namespace App\Services;

use Dingo\Api\Exception\ResourceException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FaceService {

	private $key, $secret;
	private $baseUrl = 'https://api-cn.faceplusplus.com/facepp/v3/';
	private $outerIdPrefix;

	public function __construct()
	{
		$this->key = 'VelUlj9ZtutFhCaHzWpmqfPhvp0ANYoD';//local
		$this->secret = '2TIJmSgdcvlFuf-vBdUR-HmJXziKT4RQ';//local


	}

	function dataInit() {
		$faceConfig = config('application.face');
		$curato = app('curato');
		$clientId = $curato->client->id;
		if (!isset($clientId, $faceConfig)) {
			throw new BadRequestHttpException('client error');
		}
		$this->key = $faceConfig[$clientId]['api_key'];
		$this->secret = $faceConfig[$clientId]['api_secret'];
		$this->outerIdPrefix = $faceConfig[$clientId]['faceset_code'];
	}

	function getOuterId($groupId) {
		$this->dataInit();
		return $this->outerIdPrefix. $groupId;
	}

	/**
	 * 人脸匹配 - 使用文件url
	 * @param $url
	 * @param $outerId
	 * @return bool|mixed
	 */
	function search($url, $outerId) {
		$detectResult = $this->detect($url);
		$faceToken = $detectResult['faces'][0]['face_token'];

		return $this->post('search', [
			'face_token'=>$faceToken,
			'outer_id'=>$outerId,
			'return_result_count'=>1,
		]);
	}

	/**
	 * 人脸匹配 - 使用文件
	 * @param $filePath
	 * @param $outerId
	 * @return bool|mixed
	 */
	function searchWithFile($filePath, $outerId) {
		$detectResult = $this->detectWithFile($filePath);
		$faceToken = $detectResult['faces'][0]['face_token'];

		return $this->post('search', [
			'face_token'=>$faceToken,
			'outer_id'=>$outerId,
			'return_result_count'=>1,
		]);
	}

	/**
	 * 新建人脸库
	 * @param $displayName
	 * @param $outerId
	 * @return bool|mixed
	 */
	function faceSetCreate($displayName, $outerId) {
		return $this->post('faceset/create', [
			'display_name'=>$displayName,
			'outer_id'=>$outerId,
		]);
	}

	/**
	 * 删除人脸库
	 * @param $outerId
	 * @param int $checkEmpty
	 * @return bool|mixed
	 */
	function faceSetDelete($outerId, $checkEmpty=1) {
		return $this->post('faceset/delete', [
			'outer_id'=>$outerId,
			'check_empty'=>$checkEmpty,
		]);
	}

	/**
	 * 添加人脸数据 - 使用文件url
	 * @param $url
	 * @param $outerId
	 * @param $userId
	 * @return bool|mixed
	 */
	function faceSetAddFace($url, $outerId, $userId) {

		$detectResult = $this->detect($url);

		$faceToken = $detectResult['faces'][0]['face_token'];
		$this->setUserId($faceToken, $userId);

		return $this->post('faceset/addface', [
			'outer_id'=>$outerId,
			'face_tokens'=>$faceToken,
		]);
	}

	/**
	 * 添加人脸数据 - 使用文件
	 * @param $file
	 * @param $outerId
	 * @param $userId
	 * @return bool|mixed
	 */
	function faceSetAddFaceWithFile($file, $outerId, $userId) {
		$detectResult = $this->detectWithFile($file);

		$faceToken = $detectResult['faces'][0]['face_token'];
		$this->setUserId($faceToken, $userId);

		return $this->post('faceset/addface', [
			'outer_id'=>$outerId,
			'face_tokens'=>$faceToken,
		]);
	}

	/**
	 * 抹除人脸数据
	 * @param $outerId
	 * @param $faceTokens
	 * @return bool|mixed
	 */
	function faceSetRemoveFace($outerId, $faceTokens) {
		return $this->post('faceset/removeface', [
			'outer_id'=>$outerId,
			'face_tokens'=>$faceTokens,
		]);
	}


	/**
	 * 为检测出的某一个人脸添加标识信息，该信息会在Search接口结果中返回，用来确定用户身份
	 * @param $faceToken
	 * @param $userId
	 * @return bool|mixed
	 */
	protected function setUserId($faceToken, $userId) {
		return $this->post('face/setuserid', [
			'face_token'=>$faceToken,
			'user_id'=>$userId,
		]);
	}

	/**
	 * 人脸检测 - 使用文件url
	 * @param $url
	 * @param int $returnLandmark
	 * @param string $returnAttributes
	 * @return bool|mixed
	 */
	protected function detect($url, $returnLandmark = 0, $returnAttributes = 'none') {
		return $this->post('detect', [
			'image_url'=>$url,
			'return_landmark'=>$returnLandmark,
			'return_attributes'=>$returnAttributes,
		]);
	}

	/**
	 * 人脸检测 - 使用文件
	 * @param $filePath
	 * @param int $returnLandmark
	 * @param string $returnAttributes
	 * @return bool|mixed
	 */
	protected function detectWithFile($filePath,  $returnLandmark = 0, $returnAttributes = 'none') {
		return $this->postFile('detect', [
			[
				'name'=>'image_file',
				'contents'=>fopen($filePath, 'r'),
			],
			[
				'name'=>'return_landmark',
				'contents'=>$returnLandmark,
			],
			[
				'name'=>'return_attributes',
				'contents'=>$returnAttributes,
			],
		]);
	}

	/**
	 * 获取一个Faceset的所有信息
	 * @param $outerId
	 * @return bool|mixed
	 */
	function faceSet($outerId) {
		return $this->post('faceset/getdetail', [
			'outer_id'=>$outerId,
		]);
	}

	protected function post($action, $params) {
		$this->dataInit();
		$url = $this->baseUrl.$action;
		$params = array_merge([
			'api_key' => $this->key,
			'api_secret' => $this->secret,
		], $params);
		try {
			$client =  new Client();
			$res = $client->post(
				$url,
				[
					'form_params'=>$params,
				]
			);
			$content = $res->getBody()->getContents();
			return $content ? json_decode($content, true) : false;
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				return json_decode($e->getResponse()->getBody()->getContents(), 1);
			} else {
				throw new ResourceException('Interface error.');
			}
		}

	}

	protected function postFile($action, $params) {
		$this->dataInit();
		$url = $this->baseUrl.$action;

		$params[] = [
			'name'=>'api_key',
			'contents'=>$this->key,
		];
		$params[] = [
			'name'=>'api_secret',
			'contents'=>$this->secret,
		];
		try {
			$client =  new Client();
			$res = $client->post(
				$url,
				[
					'multipart'=>$params,
				]
			);
			$content = $res->getBody()->getContents();
			return $content ? json_decode($content, true) : false;
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				return json_decode($e->getResponse()->getBody()->getContents(), 1);
			} else {
				throw new ResourceException('Interface error.');
			}
		}

	}
}