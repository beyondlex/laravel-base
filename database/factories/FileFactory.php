<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Files::class, function (Faker $faker) {
    return [
        //
        'filename'=>$faker->name,
    ];
});
