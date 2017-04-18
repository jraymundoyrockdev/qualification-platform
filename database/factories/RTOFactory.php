<?php

$factory->define(\App\Modules\RTO\RTO::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->numberBetween(100, 10000),
        'name' => $faker->name,
        'email' => $faker->email,
        'signed' => $faker->randomElement(['Y', 'N']),
        'rating_price' => $faker->numberBetween(1, 5),
        'rating_speed' => $faker->numberBetween(1, 5),
        'rating_efficiency' => $faker->numberBetween(1, 5),
        'rating_professionalism' => $faker->numberBetween(1, 5),
        'user_comments' => $faker->sentence(),
        'hidden' => $faker->randomElement(['Y', 'N']),
        'phone' => $faker->phoneNumber,
        'website' => $faker->url,
        'contact' => $faker->name,
        'form' => $faker->word . $faker->randomElement(['jpg', 'png', 'pdf'])
    ];
});