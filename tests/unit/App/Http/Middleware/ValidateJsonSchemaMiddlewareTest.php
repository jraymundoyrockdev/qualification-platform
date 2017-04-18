<?php

use App\Http\Middleware\ValidateJsonSchemaMiddleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class ValidateJsonSchemaMiddlewareTest extends BaseTestCase
{
    protected $middleware;
    protected $request;
    protected $server;

    public function setUp()
    {
        parent::setUp();

        $this->middleware = $this->app->make(ValidateJsonSchemaMiddleware::class);
        $this->request = $this->app->make(Request::class);
    }

    /** @test */
    public function it_returns_next_on_put_verb_on_successful_update()
    {
        $uuid = Uuid::uuid4();

        $this->request->setMethod('PUT');
        $this->request->request->add($this->correctPutSchema($uuid));
        $this->request->server->set('REQUEST_URI', 'www.test.com/test/' . $uuid);

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $this->assertEquals('next', $result);
    }

    /** @test */
    public function it_returns_an_error_on_put_verb_when_url_and_json_payload_uuid_is_invalid()
    {
        $this->request->setMethod('PUT');
        $this->request->request->add($this->invalidUuidPutSchema());

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Id parameter/attribute is not in uuid format', $decodedResult['errors']['detail']);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result->getStatusCode());
    }

    /** @test */
    public function it_returns_an_error_on_put_verb_when_url_id_and_json_payload_id_does_not_match()
    {
        $this->request->setMethod('PUT');
        $this->request->request->add($this->correctPutSchema(Uuid::uuid4()));
        $this->request->server->set('REQUEST_URI', 'www.test.com/test/' . Uuid::uuid4());

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Id parameter and Id json payload does not match', $decodedResult['errors']['detail']);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result->getStatusCode());
    }

    /** @test */
    public function it_returns_an_error_when_field_type_on_schema_is_missing()
    {
        $this->request->setMethod('POST');
        $this->request->request->add($this->missingTypeField());

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Malformed schema', $decodedResult['errors']['detail']);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result->getStatusCode());
    }

    /** @test */
    public function it_returns_an_error_when_schema_does_not_exist()
    {
        $this->request->setMethod('POST');
        $this->request->request->add($this->nonExistingType());

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Schema for nonExistingType does not exist.', $decodedResult['errors']['detail']);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result->getStatusCode());
    }

    /** @test */
    public function it_returns_error_on_failed_validation()
    {
        $this->request->setMethod('POST');
        $this->request->request->add($this->invalidFieldValue());

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result->getStatusCode());
        $this->assertEquals('Integer value found, but a string is required', $decodedResult['errors'][0]['title']);
        $this->assertEquals(1, count($decodedResult['errors']));
    }

    /** @test */
    public function it_returns_next_on_successful_json_schema_validation()
    {
        $this->request->setMethod('POST');
        $this->request->request->add($this->correctSchema());

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $this->assertEquals('next', $result);
    }

    /**
     * @return array
     */
    private function invalidUuidPutSchema()
    {
        return [
            'data' => [
                'id' => 'someInvalidUuid',
                'type' => 'test',
                'attributes' => [
                    'firstname' => 'foo',
                    'lastname' => 'bar'
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    private function missingTypeField()
    {
        return [
            'data' => []
        ];
    }

    /**
     * @return string
     */
    private function nonExistingType()
    {
        return [
            'data' => [
                'type' => 'nonExistingType'
            ]
        ];
    }

    /**
     * @return array
     */
    private function invalidFieldValue()
    {
        return [
            'data' => [
                'type' => 'test',
                'attributes' => [
                    'firstname' => 'foo',
                    'lastname' => 123456,
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function correctSchema()
    {
        return [
            'data' => [
                'type' => 'test',
                'attributes' => [
                    'firstname' => 'foo',
                    'lastname' => 'bar'
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function correctPutSchema($uuid)
    {
        return [
            'data' => [
                'id' => $uuid,
                'type' => 'test',
                'attributes' => [
                    'firstname' => 'foo',
                    'lastname' => 'bar'
                ]
            ]
        ];
    }
}