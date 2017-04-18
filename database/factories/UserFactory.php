<?php

$factory->define(App\Users\User::class, function(Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'password' => $faker->password(),
        'created_at' => date('Y-m-d')
    ];
});