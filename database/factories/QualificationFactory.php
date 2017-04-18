<?php

$factory->define(\App\Modules\Qualification\Qualification::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->name,
        'description' => $faker->sentence,
        'subject_information' => $faker->sentence,
        'is_superseded' => $faker->randomElement(['yes', 'no'])
    ];
});
