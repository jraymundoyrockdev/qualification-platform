<?php

$factory->define(\App\Modules\Occupation\Occupation::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->email,
        'description' => $faker->text,
        'active' => $faker->numberBetween(0, 1)
    ];
});