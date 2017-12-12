<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/11
 * Time: 上午9:53
 */

namespace App\Repositories;


use App\Criterias\RequestCriteria;
use App\Monolog;
use Prettus\Repository\Presenter\ModelFractalPresenter;

class MonologRepository extends Repository
{

    protected $fieldSearchable = [
        'message'=>'like',
        'level',
        'channel'=>'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Monolog::class;
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