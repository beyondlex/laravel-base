<?php

use Faker\Generator as Faker;

$factory->define(\App\Ads::class, function (Faker $faker) {
    return [
        //
        'client_id'=>1,
        'file_id'=> factory(\App\Files::class)->create()->id,

    ];
});
