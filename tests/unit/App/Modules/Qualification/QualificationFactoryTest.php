<?php

use App\Modules\Qualification\Qualification;
use App\Modules\Qualification\QualificationFactory;
use Faker\Factory as Faker;

class QualificationFactoryTest extends BaseTestCase
{
    /** @test */
    public function it_creates_a_new_qualification()
    {
        $faker = Faker::create();

        $code = $faker->name;
        $title = $faker->word;
        $description = $faker->sentence;
        $subjectInformation = $faker->sentence;

        $qualification = QualificationFactory::factory($code, $title, $description, $subjectInformation);

        $this->assertInstanceOf(Qualification::class, $qualification);
        $this->assertEquals($code, $qualification->getCode());
        $this->assertEquals($title, $qualification->getTitle());
        $this->assertEquals($description, $qualification->getDescription());
        $this->assertEquals($subjectInformation, $qualification->getSubjectInformation());
        $this->assertEquals('current', $qualification->getCurrencyStatus());
    }
}
