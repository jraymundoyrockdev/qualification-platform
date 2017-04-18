<?php

use App\Modules\Occupation\Occupation;
use App\Repositories\Contracts\OccupationRepository;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class OccupationControllerTest extends BaseTestCase
{
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');

        $this->repository = $this->app->make(OccupationRepository::class);
    }

    /** @test */
    public function it_returns_an_invalid_response_when_occupation_does_not_exist()
    {
        $uuid = Uuid::uuid4();

        $this->get('api/occupation/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_returns_a_valid_response_when_occupation_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(Occupation::class)->create(['id' => $uuid]);

        $this->get('api/occupation/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_and_empty_result_when_no_occupation_exist()
    {
        $this->get('api/occupation');

        $result = $this->getContent();

        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_existing_occupation_list()
    {
        entity(Occupation::class, 3)->create();

        $this->get('api/occupation');

        $result = $this->getContent();

        $this->assertCount(3, $result->data);
        $this->assertResponseOk();
    }
}
