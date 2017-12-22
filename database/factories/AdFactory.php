<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Ads::class, function (Faker $faker) {
    return [
        //
        'client_id'=>1,
        'file_id'=> factory(\App\Models\Files::class)->create()->id,

    ];
});
