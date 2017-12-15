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

    function create($ad) {
        /** @var Files $file */
        $file = factory(Files::class)->create();//@todo
        $ads = new Ads();
        $ads->client_id = 1;//@todo
        $ads->file_id = $file->id;
		$ads->fill($ad);
		$ads->save();

		return $this->ad->parserResult($ads);
    }
}