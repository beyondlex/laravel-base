<?php

use Faker\Generator as Faker;

$factory->define(\App\Department0::class, function (Faker $faker) {
    return [
        //
		'name'=>$faker->company,
		'company_id'=>(\App\Company::inRandomOrder()->first())->id,
    ];
});
