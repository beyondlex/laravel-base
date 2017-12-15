<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;

class Ads extends Model implements Transformable
{
    public function file() {
        return $this->belongsTo(Files::class);
    }

    //
    /**
     * @return array
     */
    public function transform()
    {
        return [
            'id'=>$this->id,
            'file_name'=>$this->file->filename,
            'url'=>$this->file->url,
            's_time'=>$this->s_time,
            'e_time'=>$this->e_time,
            'duration'=>$this->duration,
        ];
    }
}
