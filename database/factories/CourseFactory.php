<?php

$factory->define(\App\Modules\Course\Course::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'name' => $faker->name,
        'level' => $faker->word,
        'training_package' => $faker->sentence,
        'selling_price' => $faker->numberBetween(100, 50000),
        'initial_price' => $faker->numberBetween(100, 50000),
        'best_market_price' => $faker->numberBetween(100, 50000),
        'user_comments' => $faker->sentence,
        'target_market' => $faker->sentence,
        'times_completed' => $faker->numberBetween(0, 100),
        'active' => $faker->randomElement(['yes', 'no']),
        'status' => $faker->randomElement(['current', 'superseded', 'unknown']),
        'online' => $faker->randomElement(['yes', 'no']),
        'trades' => $faker->numberBetween(0, 1),
        'faculty' => $faker->sentence,
        'is_mapped' => $faker->word
    ];
});