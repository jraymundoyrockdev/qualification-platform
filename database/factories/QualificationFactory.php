<?php

$factory->define(\App\Modules\Qualification\Qualification::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->name,
        'description' => $faker->sentence,
        'subject_information' => $faker->sentence,
        'currency_status' => $faker->randomElement(['current', 'CHC40313']),
        'status' => $faker->randomElement(['active', 'inactive']),
        'aqf_level' => $faker->word,
        'online_learning_status' => $faker->randomElement(['active', 'inactive']),
        'rpl_status' => $faker->randomElement(['active', 'inactive']),
        'expiration_date' => $faker->date,
        'created_by' => $faker->username
    ];
});
