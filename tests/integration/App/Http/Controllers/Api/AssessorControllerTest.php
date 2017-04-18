<?php

use App\Modules\Assessor\Assessor;
use App\Modules\AssessorCourse\AssessorCourse;
use App\Users\User;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class AssessorControllerTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        Artisan::call('doctrine:schema:create');
    }

    /** @test */
    public function it_returns_a_valid_empty_response_on_fetching_assessor_with_associated_course_when_there_is_no_course_associated()
    {
        $assessor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);

        $this->get('api/assessor/' . $assessor->getId() . '/course');

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(['data', 'links'], $this->toArray($result));
        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_an_invalid_response_on_fetching_assessor_with_associated_course_when_assessor_does_not_exist()
    {
        $this->get('api/assessor/' . Uuid::uuid4() . '/course');

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(400);

    }

    /** @test */
    public function it_returns_a_valid_response_on_fetching_assessor_with_associated_course()
    {
        $assessor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);
        $assessorCourse = entity(AssessorCourse::class)->create(['id' => Uuid::uuid4()]);
        $assessorCourse2 = entity(AssessorCourse::class)->create(['id' => Uuid::uuid4()]);

        $assessor->addAssessorCourse($assessorCourse);
        $assessor->addAssessorCourse($assessorCourse2);
        $assessorCourse->setAssessor($assessor);
        $assessorCourse2->setAssessor($assessor);

        $this->get('api/assessor/' . $assessor->getId() . '/course');

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(
            ['assessor_id', 'course_code', 'cost'],
            $this->toArray($result->data[0]->data->attributes)
        );

        $this->assertEquals(2, count($result->data));
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_an_invalid_response_if_assessor_does_not_exist()
    {
        $unknownId = Uuid::uuid4();

        $this->get('api/assessor/' . $unknownId);

        $result = $this->getContent();

        $this->assertEquals('Bad Request', $result->errors->title);
        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_a_valid_api_response_if_assessor_is_found()
    {
        $uuid = Uuid::uuid4();

        entity(Assessor::class)->create(['id' => $uuid]);

        $this->get('api/assessor/' . $uuid);

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(
            ['name', 'email', 'mobile', 'notes', 'type'],
            $this->toArray($result->data->attributes)
        );
        $this->assertEquals($uuid, $result->data->id);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_an_a_valid_empty_response_when_no_assessor_exist()
    {
        $this->get('api/assessor');

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(['data', 'links'], $this->toArray($result));
        $this->assertEmpty($result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_of_list_of_assessor()
    {
        entity(Assessor::class, 5)->create();

        $this->get('api/assessor');

        $result = $this->getContent();

        $this->assertArrayHasOnlyKeys(
            ['name', 'email', 'mobile', 'notes', 'type'],
            $this->toArray($result->data[0]->data->attributes)
        );

        $this->assertCount(5, $result->data);
        $this->assertResponseOk();
    }

    /** @test */
    public function it_returns_a_valid_response_on_successful_insert()
    {
        $this->post('api/assessor', $this->validJsonPayload());

        $this->assertResponseStatus(201);
    }

    /**
     * @test
     * @dataProvider invalidJsonPayloadProvider
     */
    public function it_returns_error_on_insert_when_json_payload_is_invalid($errorType, $payload)
    {
        $this->app->instance('middleware.disable', false);

        $token = JWTAuth::fromUser(entity(User::class)->make(['id' => Uuid::uuid4()]));

        $this->refreshApplication();

        $payload = json_decode($payload, true);

        $this->post('api/assessor', $payload, ['Authorization' => 'Bearer ' . $token]);

        $result = $this->getContent();

        $expectedError = $this->expectedErrorDetails($errorType);

        if (is_array($result->errors)) {
            $title = $result->errors[0]->title;
            $detail = $result->errors[0]->detail;
        } else {
            $title = $result->errors->title;
            $detail = $result->errors->detail;
        }

        $this->assertEquals($expectedError['title'], $title);
        $this->assertEquals($expectedError['detail'], $detail);

        $this->assertResponseStatus(422);
    }

    /**
     * @test
     * @dataProvider invalidJsonPayloadProviderForUpdate
     */
    public function it_returns_invalid_response_on_update_when_json_payload_is_invalid($errorType, $payload)
    {
        $assessor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);

        $this->app->instance('middleware.disable', false);

        $token = JWTAuth::fromUser(entity(User::class)->make(['id' => Uuid::uuid4()]));

        $this->refreshApplication();

        $payload = json_decode($payload, true);

        $this->put('api/assessor/' . $assessor->getId(), $payload, ['Authorization' => 'Bearer ' . $token]);

        $result = $this->getContent();

        $expectedError = $this->expectedErrorDetails($errorType);


        if (is_array($result->errors)) {
            $title = $result->errors[0]->title;
            $detail = $result->errors[0]->detail;
        } else {
            $title = $result->errors->title;
            $detail = $result->errors->detail;
        }

        $this->assertEquals($expectedError['title'], $title);
        $this->assertEquals($expectedError['detail'], $detail);

        $this->assertResponseStatus(422);
    }

    /** @test */
    public function it_returns_an_invalid_response_on_update_when_assessor_does_not_exist()
    {
        $this->put('api/assessor/' . Uuid::uuid4());

        $this->assertResponseStatus(400);
    }

    /** @test */
    public function it_returns_an_invalid_response_on_update_when_assessor_id_does_not_match_request_id()
    {
        $this->app->instance('middleware.disable', false);

        $token = JWTAuth::fromUser(entity(User::class)->make(['id' => Uuid::uuid4()]));

        $this->refreshApplication();

        Artisan::call('doctrine:schema:create');

        $requestAssesssor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);
        $payloadAssesssor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);

        $this->put(
            'api/assessor/' . $requestAssesssor->getId(),
            $this->validUpdateJsonPayload($payloadAssesssor->getId()),
            ['Authorization' => 'Bearer ' . $token]
        );

        $result = $this->getContent();

        $this->assertEquals('Unprocessable Entity', $result->errors->title);
        $this->assertEquals('Id parameter and Id json payload does not match', $result->errors->detail);
        $this->assertResponseStatus(422);
    }

    /** @test */
    public function it_returns_an_invalid_response_on_update_when_assessor_id_or_request_id_is_not_a_valid_uuid()
    {
        $this->app->instance('middleware.disable', false);

        $token = JWTAuth::fromUser(entity(User::class)->make(['id' => Uuid::uuid4()]));

        $this->refreshApplication();

        Artisan::call('doctrine:schema:create');

        $this->put(
            'api/assessor/invalidUuid',
            $this->validUpdateJsonPayload('invalidUuid'),
            ['Authorization' => 'Bearer ' . $token]
        );

        $result = $this->getContent();

        $this->assertEquals('Unprocessable Entity', $result->errors->title);
        $this->assertEquals('Id parameter/attribute is not in uuid format', $result->errors->detail);
        $this->assertResponseStatus(422);
    }

    /** @test */
    public function it_returns_a_valid_response_on_successful_update()
    {
        $assessor = entity(Assessor::class)->create(['id' => Uuid::uuid4()]);

        $this->put('api/assessor/' . $assessor->getId(), $this->validUpdateJsonPayload($assessor->getId()));

        $this->assertResponseStatus(200);
    }

    /**
     * @return array
     */
    private function validJsonPayload()
    {
        return json_decode(
            '{
                "data": {
                    "type": "assessor",
                    "attributes": {
                        "name": "sample name",
                        "email": "test@gmail.com",
                        "mobile": "090921",
                        "notes": "this is a sample note",
                        "type": "ft_gq"
                    }
                }
            }',
            true
        );
    }

    /**
     * @return array
     */
    private function validUpdateJsonPayload($id)
    {
        return json_decode(
            '{
                "data": {
                    "id": "' . $id . '",
                    "type": "assessor",
                    "attributes": {
                        "name": "nameSuccessFulUpdate",
                        "email": "update@gmail.com",
                        "mobile": "update0909",
                        "notes": "a sample updated notes",
                        "type": "ft_gq"
                    }
                }
            }',
            true
        );
    }

    /**
     * @return array
     */
    public function invalidJsonPayloadProvider()
    {
        return [
            ['missing_data', '{}'],
            ['additional_property_on_top_level_key', '{"data": {"type": "assessor","attributes": {"name": "sample name","email": "test@gmail.com","mobile": "090921","notes": "this is a sample note","type": "ft_gq"}},"extra":{}}'],
            ['missing_key_type', '{"data": {"attributes": {}}}'],
            ['missing_key_attributes', '{"data": {"type": "assessor"}}'],
            ['missing_data_attributes_name', '{"data": {"type": "assessor","attributes": {"email": "test@gmail.com","mobile": "090921","notes": "this is a sample note","type": "ft_gq"}}}'],
            ['missing_data_attributes_email', '{"data": {"type": "assessor","attributes": {"name": "sample name", "mobile": "090921","notes": "this is a sample note","type": "ft_gq"}}}'],
            ['missing_data_attributes_mobile', '{"data": {"type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com","notes": "this is a sample note","type": "ft_gq"}}}'],
            ['missing_data_attributes_notes', '{"data": {"type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","type": "ft_gq"}}}'],
            ['missing_data_attributes_type', '{"data": {"type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","notes": "this is a sample note"}}}'],
            ['additional_property_on_data_attributes', '{"data": {"type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","notes": "this is a sample note","type": "ft_gq","extra":"extraValue"}}}'],
            ['additional_property_on_data', '{"data": {"type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","notes": "this is a sample note","type": "ft_gq"},"extra":"extraValue"}}']
        ];
    }

    /**
     * @return array
     */
    public function invalidJsonPayloadProviderForUpdate()
    {
        return [
            ['missing_data', '{}'],
            ['additional_property_on_top_level_key', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name","email": "test@gmail.com","mobile": "090921","notes": "this is a sample note","type": "ft_gq"}},"extra":{}}'],
            ['missing_key_id', '{"data": {"type": "assessor", "attributes": {}}}'],
            ['missing_key_type', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "attributes": {}}}'],
            ['missing_key_attributes', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor"}}'],
            ['missing_data_attributes_name', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"email": "test@gmail.com","mobile": "090921","notes": "this is a sample note","type": "ft_gq"}}}'],
            ['missing_data_attributes_email', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name", "mobile": "090921","notes": "this is a sample note","type": "ft_gq"}}}'],
            ['missing_data_attributes_mobile', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com","notes": "this is a sample note","type": "ft_gq"}}}'],
            ['missing_data_attributes_notes', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","type": "ft_gq"}}}'],
            ['missing_data_attributes_type', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","notes": "this is a sample note"}}}'],
            ['additional_property_on_data_attributes', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","notes": "this is a sample note","type": "ft_gq","extra":"extraValue"}}}'],
            ['additional_property_on_data', '{"data": {"id":"3617b07d-1d52-460f-bc29-1541c6d056bc", "type": "assessor","attributes": {"name": "sample name", "email": "test@gmail.com", "mobile": "090921","notes": "this is a sample note","type": "ft_gq"},"extra":"extraValue"}}']
        ];
    }
    /**
     * @param $type
     *
     * @return array
     */
    private function expectedErrorDetails($type)
    {
        $errors = [
            'missing_key_id' => ['title' => 'The property id is required', 'detail' => 'data.id'],
            'missing_data' => ['detail' => 'Malformed schema', 'title' => 'Unprocessable Entity'],
            'additional_property_on_top_level_key' => ['title' => 'The property extra is not defined and the definition does not allow additional properties', 'detail' => ''],
            'missing_key_type' => ['detail' => 'Malformed schema', 'title' => 'Unprocessable Entity'],
            'missing_key_attributes' => ['title' => 'The property attributes is required', 'detail' => 'data.attributes'],
            'missing_data_attributes_name' => ['title' => 'The property name is required', 'detail' => 'data.attributes.name'],
            'missing_data_attributes_email' => ['title' => 'The property email is required', 'detail' => 'data.attributes.email'],
            'missing_data_attributes_mobile' => ['title' => 'The property mobile is required', 'detail' => 'data.attributes.mobile'],
            'missing_data_attributes_notes' => ['title' => 'The property notes is required', 'detail' => 'data.attributes.notes'],
            'missing_data_attributes_type' => ['title' => 'The property type is required', 'detail' => 'data.attributes.type'],
            'additional_property_on_data_attributes' => ['title' => 'The property extra is not defined and the definition does not allow additional properties', 'detail' => 'data.attributes'],
            'additional_property_on_data' => ['title' => 'The property extra is not defined and the definition does not allow additional properties', 'detail' => 'data']
        ];

        return $errors[$type];
    }
}
