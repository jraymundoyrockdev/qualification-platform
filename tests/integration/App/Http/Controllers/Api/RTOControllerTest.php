<?php

use App\Modules\RTO\RTO;
use App\Repositories\Contracts\RTORepository;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class RTOControllerTest extends BaseTestCase
{
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');

        $this->repository = $this->app->make(RTORepository::class);
    }

    /** @test */
    public function it_returns_an_invalid_response_when_rto_does_not_exist()
    {
        $uuid = Uuid::uuid4();

        $this->get('api/rto/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_returns_a_valid_response_when_rto_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(RTO::class)->create(['id' => $uuid]);

        $this->get('api/rto/' . $uuid);

        $result = $this->getContent();

        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_when_no_rto_exist()
    {
        $this->get('api/rto');

        $result = $this->getContent();

        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_existing_rto_list()
    {
        entity(RTO::class, 5)->create(['id' => Uuid::uuid4()]);

        $this->get('api/rto');

        $result = $this->getContent();

        $this->assertCount(5, $result->data);
        $this->assertResponseOk();
    }
}
