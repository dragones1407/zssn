<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model;
use App\Superviviente;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(App\Superviviente::class, function (Faker $faker) {
    $generoValores = ['Hombre', 'Mujer'];

    return [
        'nombre' => $faker->name,
        'edad' => $faker->numberBetween(10, 60),
        'genero' => $generoValores[rand(0, 1)],
        'latitud' => $faker->randomFloat(),
        'longitud' => $faker->randomFloat(),
        'infectado' => false,
        'reportado' => 0,
    ];
});
