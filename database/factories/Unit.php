<?php

$factory->define(\App\Modules\Unit\Unit::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->word,
        'group_name' => $faker->randomElement(['core', 'elective']),
        'subgroup' => $faker->word
    ];
});
