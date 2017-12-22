<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/15
 * Time: 上午11:58
 */

namespace App\Repositories;


use App\Models\Ads;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Presenter\ModelFractalPresenter;

class AdRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ads::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return ModelFractalPresenter::class;
    }
}