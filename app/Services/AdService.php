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
use Illuminate\Support\Facades\Input;

class AdService {

    private $ad;

    public function __construct(AdRepository $ad)
    {
        $this->ad = $ad;
    }

    function find($id) {
        return $this->ad->find($id);
    }

    function all() {
        $perPage = (int) (Input::get('perPage') ?? 5);//@todo
        $data = $this->ad->paginate($perPage);
        return $data;
    }

    function create($data) {
        /** @var Files $file */
        $file = factory(Files::class)->create();//@todo
        $ad = new Ads();
        $ad->client_id = 1;//@todo
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
}