<?php

use Faker\Generator as Faker;

$factory->define(App\Medecin::class, function (Faker $faker) {
    return [
        'nom' => $faker->firstname,
        'prenom' => $faker->lastname,
        'sexe' => 'Male',
        'image' => 'img/medecins/images01.jpg',
        'adresse' => $faker->address,
        'bio' => $faker->text,
        'telephone' => $faker->phoneNumber,
        'langues' => 'francais',
        'city' => $faker->city,
        'tarif_de' => rand(15, 100),
        'tarif_a' =>  rand(5, 15),
        'user_id' =>  function () { return factory(App\User::class)->create()->id; },
        'specialite_id' =>  function () { return factory(App\Specialite::class)->create()->id; }
    ];
});
