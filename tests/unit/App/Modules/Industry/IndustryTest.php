<?php

use App\Modules\Industry\Industry;
use App\Resolvers\ProvidesUuidValidation;
use Faker\Factory as Faker;

class IndustryTest extends BaseTestCase
{
    use ProvidesUuidValidation;

    protected $industry;

    /** @test */
    public function it_returns_the_property_id()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);

        $this->assertNotEmpty($industry->getId());
        $this->assertTrue($this->isValidUuid($industry->getId()->toString()));

    }

    /** @test */
    public function it_sets_the_property_code()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);
        $industry->setCode('newCode');

        $this->assertEquals('newCode', $industry->getCode());
        $this->assertInstanceOf(Industry::class, $industry->setCode('newCode'));
    }

    /** @test */
    public function it_returns_the_property_code()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);

        $this->assertEquals($code, $industry->getCode());
    }

    /** @test */
    public function it_sets_the_property_title()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);
        $industry->setTitle('newTitle');

        $this->assertEquals('newTitle', $industry->getTitle());
        $this->assertInstanceOf(Industry::class, $industry->setTitle('newTitle'));
    }

    /** @test */
    public function it_returns_the_property_title()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);

        $this->assertEquals($title, $industry->getTitle());
    }

    /** @test */
    public function it_sets_the_property_description()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);
        $industry->setDescription('newDescription');

        $this->assertEquals('newDescription', $industry->getDescription());
        $this->assertInstanceOf(Industry::class, $industry->setDescription('newDescription'));
    }

    /** @test */
    public function it_returns_the_property_description()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);

        $this->assertEquals($description, $industry->getDescription());
    }

    /** @test */
    public function it_sets_the_property_active()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);
        $industry->setActive('newActive');

        $this->assertEquals('newActive', $industry->getActive());
        $this->assertInstanceOf(Industry::class, $industry->setActive('newActive'));
    }

    /** @test */
    public function it_returns_the_property_parent_code()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);

        $this->assertEquals($parent_code, $industry->getParentCode());
    }

    /** @test */
    public function it_sets_the_property_parent_code()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);
        $industry->setParentCode('newParentCode');

        $this->assertEquals('newParentCode', $industry->getParentCode());
        $this->assertInstanceOf(Industry::class, $industry->setParentCode('newParentCode'));
    }

    /** @test */
    public function it_returns_the_property_active()
    {
        list($code, $title, $description, $parent_code, $active) = $this->createNewIndustry();

        $industry = new Industry($code, $title, $description, $parent_code, $active);

        $this->assertEquals($active, $industry->getActive());
    }

    /**
     * @return array
     */
    private function createNewIndustry()
    {
        $faker = Faker::create();

        return [$faker->word, $faker->title, $faker->sentence, $faker->word, $faker->numberBetween(0, 1)];
    }
}
