<?php

use App\Modules\Unit\Unit;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class UnitControllerTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');
    }

    /** @test */
    public function it_returns_an_invalid_response_if_unit_does_not_exist()
    {
        $unknownId = Uuid::uuid4();

        $this->get('api/unit/' . $unknownId);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_a_valid_api_response_if_unit_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(Unit::class)->create(['id' => $uuid]);

        $this->get('api/unit/' . $uuid);

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(
            ['code', 'title', 'group_name', 'subgroup'],
            $this->toArray($result->data->attributes)
        );

        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_and_empty_result_when_no_unit_exist()
    {
        $this->get('api/unit');

        $result = $this->getContent();

        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_existing_unit_list()
    {
        entity(Unit::class, 3)->create();

        $this->get('api/unit');

        $result = $this->getContent();

        $this->assertCount(3, $result->data);
        $this->assertResponseOk();
    }
}
