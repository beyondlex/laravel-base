<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Company::class, function (Faker $faker) {
    return [
        //
		'name'=>$faker->company,
		'code'=>$faker->unique()->randomNumber(),

    ];
});
