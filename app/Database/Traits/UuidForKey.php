<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/15
 * Time: 上午11:39
 */
namespace App\Database\Traits;

use Ramsey\Uuid\Uuid;

trait UuidForKey {
    public static function bootUuidForKey()
    {
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
    }

    public function getCasts()
    {
        return $this->casts;
    }

}