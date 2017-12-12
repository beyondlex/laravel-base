<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;

class Monolog extends Model implements Transformable
{
    //
    protected $connection = 'mongodb';

    /**
     * @return array
     */
    public function transform()
    {
        return [
            'channel'=>$this->channel,
            'level'=>$this->level,
            'message'=>$this->message,
            'context'=>$this->context,
            'extra'=>$this->extra,
            'updated_at'=>$this->updated_at,
            'created_at'=>$this->created_at,
        ];
    }
}
