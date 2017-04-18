<?php

use App\Modules\Scientist\ScientistFactory;
use App\Repositories\Contracts\ScientistRepository;
use App\Repositories\Doctrines\DoctrineScientistRepository;
use Illuminate\Support\Facades\Artisan;

class DoctrineScientistRepositoryTest extends BaseTestCase
{
    /**
     * @var DoctrineScientistRepository
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('doctrine:schema:create');

        $this->repository = $this->app->make(ScientistRepository::class);
    }

    /** @test */
    public function it_creates_new_scientist()
    {
        $result = $this->repository->create($this->insert_payload());

        $this->assertEquals('sampleFirstName', $result->getFirstname());
    }

    private function insert_payload()
    {
        return ScientistFactory::create('sampleFirstName', 'sampleLastname');
    }
}