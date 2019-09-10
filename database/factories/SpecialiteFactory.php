<?php

use Faker\Generator as Faker;

$factory->define(App\Specialite::class, function (Faker $faker) {
    return [
        'libelle' => $faker->title,
    ];
});
