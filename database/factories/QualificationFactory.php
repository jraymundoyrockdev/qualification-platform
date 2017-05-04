<?php

$factory->define(\App\Modules\Qualification\Qualification::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->name,
        'description' => $faker->sentence,
        'subject_information' => $faker->sentence,
        'currency_status' => $faker->randomElement(['current', 'CHC40313'])
    ];
});
