<?php

use App\Modules\Industry\Industry;
use App\Repositories\Contracts\IndustryRepository;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class IndustryControllerTest extends BaseTestCase
{
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');

        $this->repository = $this->app->make(IndustryRepository::class);
    }

    /** @test */
    public function it_returns_an_invalid_response_when_industry_does_not_exist()
    {
        $uuid = Uuid::uuid4();

        $this->get('api/industry/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_returns_a_valid_response_when_industry_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(Industry::class)->create(['id' => $uuid]);

        $this->get('api/industry/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_and_empty_result_when_no_industry_exist()
    {
        $this->get('api/industry');

        $result = $this->getContent();

        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_existing_industry_list()
    {
        entity(Industry::class, 3)->create();

        $this->get('api/industry');

        $result = $this->getContent();

        $this->assertCount(3, $result->data);
        $this->assertResponseOk();
    }
}
