<?php

$factory->define(\App\Modules\AssessorCourse\AssessorCourse::class, function (Faker\Generator $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
        'assessor_id' => \Ramsey\Uuid\Uuid::uuid4(),
        'course_code' => $faker->word,
        'cost' => $faker->numberBetween()
    ];
});