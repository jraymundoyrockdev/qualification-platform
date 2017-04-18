<?php

use App\Modules\Occupation\Occupation;
use App\Modules\Package\Package;
use App\Resolvers\ProvidesUuidValidation;
use Faker\Factory as Faker;

class PackageTest extends BaseTestCase
{
    use ProvidesUuidValidation;

    protected $package;

    /** @test */
    public function it_returns_the_property_id()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);

        $this->assertNotEmpty($package->getId());
        $this->assertTrue($this->isValidUuid($package->getId()->toString()));

    }

    /** @test */
    public function it_sets_the_property_code()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);
        $package->setCode('newCode');

        $this->assertEquals('newCode', $package->getCode());
        $this->assertInstanceOf(Package::class, $package->setCode('newCode'));
    }

    /** @test */
    public function it_returns_the_property_code()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);

        $this->assertEquals($code, $package->getCode());
    }

    /** @test */
    public function it_sets_the_property_title()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);
        $package->setTitle('newTitle');

        $this->assertEquals('newTitle', $package->getTitle());
        $this->assertInstanceOf(Package::class, $package->setTitle('newTitle'));
    }

    /** @test */
    public function it_returns_the_property_title()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);

        $this->assertEquals($title, $package->getTitle());
    }


    /** @test */
    public function it_sets_the_property_status()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);
        $package->setStatus('newStatus');

        $this->assertEquals('newStatus', $package->getStatus());
        $this->assertInstanceOf(Package::class, $package->setStatus('newStatus'));
    }

    /** @test */
    public function it_returns_the_property_status()
    {
        list($code, $title, $status) = $this->createNewPackage();

        $package = new Package($code, $title, $status);

        $this->assertEquals($status, $package->getStatus());
    }

    /**
     * @return array
     */
    private function createNewPackage()
    {
        $faker = Faker::create();

        return [$faker->word, $faker->title, $faker->numberBetween(0, 1)];
    }
}
