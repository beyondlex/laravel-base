<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/15
 * Time: 下午1:54
 */
namespace App\Services;


use App\Ads;
use App\Files;
use App\Repositories\AdRepository;

class AdService {

    private $ad;
    private $fileService;

    public function __construct(AdRepository $ad, FileService $fileService)
    {
        $this->ad = $ad;
        $this->fileService = $fileService;
    }

    function all() {
    	return $this->ad->all();
	}

    function find($id) {
        return $this->ad->find($id);
    }

    function paginate($perPage) {
    	$perPage = $perPage ?? 5;
		$data = $this->ad->paginate($perPage);
		return $data;
	}

    function create($data) {
        /** @var Files $file */
//        $file = factory(Files::class)->create();
		$curato = app('curato');// Initial at the ApiAuthenticationMiddleware
		$file = $this->fileService->store('ads');// Storing to directory: public/ads
        $ad = new Ads();
//        $ad->client_id = 1;
		$ad->client_id = $curato->client->id;
        $ad->file_id = $file->id;
		$ad->fill($data);
		$ad->save();

		return $this->ad->parserResult($ad);//Same as $ad->presenter()
    }

    function update($id, $data) {
    	/** @var Ads $ad */
    	$ad = $this->ad->skipPresenter()->find($id);

    	$ad->fill($data);
    	$ad->save();

    	return $ad->presenter();

	}

	function delete($id) {
    	return $this->ad->delete($id);
	}
}