<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Recurso;
use Faker\Generator as Faker;

$factory->define(App\Recurso::class, function (Faker $faker) {
    return [
        //
        'superviviente_id' => $faker->unique()->numberBetween(4, 10),
        'item_id' => $faker->numberBetween(1, 4),
        'cantidad' => $faker->numberBetween(1, 5)
    ];
});
