<?php

$factory->define(\App\Modules\Assessor\Assessor::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'name' => $faker->name,
        'email' => $faker->email,
        'mobile' => $faker->phoneNumber,
        'notes' => $faker->sentence,
        'type' => $faker->randomElement(['full_time_gq', 'part_time_gq', 'rto'])
    ];
});