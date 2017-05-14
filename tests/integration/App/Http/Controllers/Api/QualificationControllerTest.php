<?php

use App\Modules\Qualification\Qualification;
use App\Users\User;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class QualificationControllerTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');
    }

    /** @test */
    public function it_returns_an_invalid_response_on_adding_new_qualification_from_tga_when_json_payload_is_invalid()
    {

    }

    /** @test */
    public function it_returns_an_invalid_response_on_adding_new_qualification_from_tga_when_qualification_already_exist()
    {
        $token = $this->generateJWT();

        $existingQualification = entity(Qualification::class)->create();

        $this->post(
            'api/qualification-add-from-tga',
            $this->validJsonPayload($existingQualification->getCode()),
            ['Authorization' => 'Bearer ' . $token]
        );

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertEquals('Qualification already exist.', $result->errors->detail);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_an_invalid_response_on_adding_new_qualification_from_tga_when_qualification_code_does_not_exist_on_tga_site()
    {
        $token = $this->generateJWT();

        $this->post(
            'api/qualification-add-from-tga',
            $this->validJsonPayload('nonExistingCode'),
            ['Authorization' => 'Bearer ' . $token]
        );

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertEquals('Qualification does not exist in TGA.', $result->errors->detail);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_an_invalid_response_on_adding_new_qualification_if_code_is_not_a_valid_qualification_component_on_tga_site()
    {
        $token = $this->generateJWT();

        $this->post(
            'api/qualification-add-from-tga',
            $this->validJsonPayload('BSBADV503'),
            ['Authorization' => 'Bearer ' . $token]
        );

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertEquals('Component is not a valid Qualification.', $result->errors->detail);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_a_valid_response_on_successfull_adding_new_qualification_from_tga()
    {
        $token = $this->generateJWT();

        $this->post(
            'api/qualification-add-from-tga',
            $this->validJsonPayload('FNS40215'),
            ['Authorization' => 'Bearer ' . $token]
        );

        $result = $this->getContent();

        $this->assertResponseStatus(201);
    }

    /** @test */
    public function it_returns_an_empty_response_when_qualification_does_not_exist()
    {
        $unknownId = Uuid::uuid4();

        $this->get('api/qualification/' . $unknownId);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_a_qualification()
    {
        $uuid = Uuid::uuid4();

        entity(Qualification::class)->create(['id' => $uuid]);

        $this->get('api/qualification/' . $uuid);

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(['data', 'links'], $this->toArray($result));

        $this->assertArrayHasOnlyKeys(
            ['code', 'title', 'description', 'packaging_rules', 'currency_status', 'status', 'aqf_level', 'online_learning_status', 'rpl_status', 'expiration_date', 'created_by'],
            $this->toArray($result->data->attributes)
        );
        $this->assertEquals($uuid, $result->data->id);
        $this->assertEquals('qualification', $result->data->type);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_an_empty_collection_when_qualification_does_not_exist()
    {
        $this->get('api/qualification/');

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(['data', 'links'], $this->toArray($result));
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_of_list_of_qualification()
    {
        entity(Qualification::class, 5)->create();

        $this->get('api/qualification');

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(
            ['code', 'title', 'description', 'packaging_rules', 'currency_status', 'status', 'aqf_level', 'online_learning_status', 'rpl_status', 'expiration_date', 'created_by'],
            $this->toArray($result->data[0]->data->attributes)
        );

        $this->assertCount(5, $result->data);
        $this->assertResponseOk();
    }

    /**
     * @return array
     */
    private function validJsonPayload($qualificationCode)
    {
        return json_decode(
            '{
                "data": {
                    "type": "qualification",
                    "attributes": {
                        "code":"' . $qualificationCode . '"
                    }
                }
            }',
            true
        );
    }

    private function generateJWT()
    {
        $this->app->instance('middleware.disable', false);

        $token = JWTAuth::fromUser(entity(User::class)->make(['id' => Uuid::uuid4()]));

        $this->refreshApplication();

        Artisan::call('doctrine:schema:create');

        return $token;
    }
}
