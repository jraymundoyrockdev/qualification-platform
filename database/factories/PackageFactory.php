<?php

$factory->define(\App\Modules\Package\Package::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->email,
        'status' => $faker->numberBetween(0, 1)
    ];
});
