<?php

use App\Modules\Occupation\Occupation;
use App\Resolvers\ProvidesUuidValidation;
use Faker\Factory as Faker;

class OccupationTest extends BaseTestCase
{
    use ProvidesUuidValidation;

    protected $occupation;

    /** @test */
    public function it_returns_the_property_id()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);

        $this->assertNotEmpty($occupation->getId());
        $this->assertTrue($this->isValidUuid($occupation->getId()->toString()));

    }

    /** @test */
    public function it_sets_the_property_code()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);
        $occupation->setCode('newCode');

        $this->assertEquals('newCode', $occupation->getCode());
        $this->assertInstanceOf(Occupation::class, $occupation->setCode('newCode'));
    }

    /** @test */
    public function it_returns_the_property_code()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);

        $this->assertEquals($code, $occupation->getCode());
    }

    /** @test */
    public function it_sets_the_property_title()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);
        $occupation->setTitle('newTitle');

        $this->assertEquals('newTitle', $occupation->getTitle());
        $this->assertInstanceOf(Occupation::class, $occupation->setTitle('newTitle'));
    }

    /** @test */
    public function it_returns_the_property_title()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);

        $this->assertEquals($title, $occupation->getTitle());
    }

    /** @test */
    public function it_sets_the_property_description()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);
        $occupation->setDescription('newDescription');

        $this->assertEquals('newDescription', $occupation->getDescription());
        $this->assertInstanceOf(Occupation::class, $occupation->setDescription('newDescription'));
    }

    /** @test */
    public function it_returns_the_property_description()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);

        $this->assertEquals($description, $occupation->getDescription());
    }

    /** @test */
    public function it_sets_the_property_active()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);
        $occupation->setActive('newActive');

        $this->assertEquals('newActive', $occupation->getActive());
        $this->assertInstanceOf(Occupation::class, $occupation->setActive('newActive'));
    }

    /** @test */
    public function it_returns_the_property_active()
    {
        list($code, $title, $description, $active) = $this->createNewOccupation();

        $occupation = new Occupation($code, $title, $description, $active);

        $this->assertEquals($active, $occupation->getActive());
    }

    /**
     * @return array
     */
    private function createNewOccupation()
    {
        $faker = Faker::create();

        return [$faker->word, $faker->title, $faker->sentence, $faker->numberBetween(0, 1)];
    }
}
