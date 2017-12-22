<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/15
 * Time: 下午1:54
 */
namespace App\Services;


use App\Models\Ads;
use App\Criterias\ClientCriteria;
use App\Exceptions\Traits\ClientTrait;
use App\Models\Files;
use App\Repositories\AdRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdService {

	use ClientTrait;

    private $ad;
    private $fileService;

    public function __construct(AdRepository $ad, FileService $fileService)
    {
        $this->ad = $ad;
        $this->fileService = $fileService;
    }

    function all() {
    	$clientId = $this->getClientId();
    	return $this->ad->pushCriteria(new ClientCriteria($clientId))->all();
	}

    function find($id) {
        return $this->ad->pushCriteria(new ClientCriteria($this->getClientId()))->find($id);
    }

    function paginate($perPage) {
    	$perPage = $perPage ?? 5;
    	$clientId = $this->getClientId();
		$data = $this->ad->pushCriteria(new ClientCriteria($clientId))->paginate($perPage);
		return $data;
	}

    function create($data) {
        /** @var Files $file */
//        $file = factory(Files::class)->create();
		$file = $this->fileService->store('ads');// Storing to directory: public/ads
        $ad = new Ads();
//        $ad->client_id = 1;
		$ad->client_id = $this->getClientId();
        $ad->file_id = $file->id;
		$ad->fill($data);
		$ad->save();

		return $this->ad->parserResult($ad);//Same as $ad->presenter()
    }

    function update($id, $data) {
    	/** @var Ads $ad */
    	$ad = $this->ad->skipPresenter()->find($id);

    	if ($ad->client_id != $this->getClientId()) {
    		throw new NotFoundHttpException('Resource not found');
		}

    	$ad->fill($data);
    	$ad->save();

    	return $ad->presenter();

	}

	function delete($id) {
    	/** @var Ads $ad */
    	$ad = $this->ad->skipPresenter()->find($id);
    	if ($ad->client_id != $this->getClientId()) {
    		throw new NotFoundHttpException('Resource not found');
		}
    	return $this->ad->delete($id);
	}
}