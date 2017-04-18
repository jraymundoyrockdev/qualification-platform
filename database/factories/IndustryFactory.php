<?php

$factory->define(\App\Modules\Industry\Industry::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'code' => $faker->word,
        'title' => $faker->email,
        'description' => $faker->text,
        'parent_code' => $faker->word,
        'active' => $faker->numberBetween(0, 1)
    ];
});
