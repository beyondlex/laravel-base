<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\PresenterInterface;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * @property int client_id
 * @property mixed file_id
 * @property mixed id
 * @property mixed s_time
 * @property mixed e_time
 * @property mixed duration
 * @property mixed device
 * @property mixed type
 * @property Files file
 */
class Ads extends Model implements Transformable, Presentable
{

	use PresentableTrait;
	use SoftDeletes;

	protected $fillable = [
		'type', 'duration', 'device'
	];

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
            'url'=> "http://{$_SERVER['HTTP_HOST']}". $this->file->url,
            's_time'=>$this->s_time,
            'e_time'=>$this->e_time,
            'duration'=>$this->duration,
//			'device'=>$this->device,
//			'type'=>$this->type,
        ];
    }


}
