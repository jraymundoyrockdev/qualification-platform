<?php

use App\Modules\Assessor\Assessor;
use App\Modules\Assessor\AssessorFactory;
use Faker\Factory as Faker;

class AssessorFactoryTest extends BaseTestCase
{
    /** @test */
    public function it_creates_a_new_assessor()
    {
        $faker = Faker::create();

        $name = $faker->name;
        $email = $faker->email;
        $mobile = $faker->phoneNumber;
        $notes = $faker->sentence;
        $type = $faker->randomElement(['full_time_gq', 'part_time_gq', 'rto']);

        $assessor = AssessorFactory::factory($name, $email, $mobile, $notes, $type);

        $this->assertInstanceOf(Assessor::class, $assessor);
        $this->assertEquals($name, $assessor->getName());
        $this->assertEquals($email, $assessor->getEmail());
        $this->assertEquals($mobile, $assessor->getMobile());
        $this->assertEquals($notes, $assessor->getNotes());
        $this->assertEquals($type, $assessor->getType());
    }
}
