<?php

use App\Modules\Package\Package;
use App\Repositories\Contracts\PackageRepository;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class PackageControllerTest extends BaseTestCase
{
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');

        $this->repository = $this->app->make(PackageRepository::class);
    }

    /** @test */
    public function it_returns_an_invalid_response_when_package_does_not_exist()
    {
        $uuid = Uuid::uuid4();

        $this->get('api/package/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_returns_a_valid_response_when_package_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(Package::class)->create(['id' => $uuid]);

        $this->get('api/package/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_and_empty_result_when_no_package_exist()
    {
        $this->get('api/package');

        $result = $this->getContent();

        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_existing_package_list()
    {
        entity(Package::class, 3)->create();

        $this->get('api/package');

        $result = $this->getContent();

        $this->assertCount(3, $result->data);
        $this->assertResponseOk();
    }
}
