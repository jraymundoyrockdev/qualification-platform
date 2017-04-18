<?php

use App\Exceptions\PageNotFoundException;
use App\Exceptions\NotAValidQualificationException;
use App\Modules\Qualification\Qualification;
use App\Repositories\Contracts\QualificationRepository;
use App\Services\Sync\SyncQualificationService;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class SyncQualificationServiceTest extends BaseTestCase
{
    protected $service;
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('doctrine:schema:create');

        $this->service = $this->app->make(SyncQualificationService::class);
        $this->repository = $this->app->make(QualificationRepository::class);
    }

    /** @test */
    public function it_throws_an_exception_when_qualification_does_not_exist()
    {
        $this->setExpectedException(PageNotFoundException::class);

        $result = $this->service->sync('nonExistingCode');
    }

    /** @test */
    public function it_throws_an_exception_on_fetching_from_tga_when_code_is_not_a_valid_qualification()
    {
        $this->setExpectedException(NotAValidQualificationException::class);

        $result = $this->service->sync('BSBADV503');
    }

    /** @test */
    public function it_returns_a_qualification_on_successful_sync()
    {
        $result = $this->service->sync('FNS40215');

        $databaseResult = $this->repository->findOneBy(['code' =>'FNS40215']);

        $this->assertInstanceOf(Qualification::class, $databaseResult);
        $this->assertEquals(1, count($databaseResult));
    }
}
