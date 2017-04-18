<?php

use App\Http\Response\AbstractApiResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiResponseTest extends BaseTestCase
{
    const CONTENT_TYPE = 'application/vnd.api+json';

    protected $response;

    public function setUp()
    {
        parent::setUp();

        $this->response = $this->getMockForAbstractClass(AbstractApiResponse::class);
    }

    /** @test */
    public function it_returns_status_code()
    {
        $result = $this->response->getStatusCode();

        $this->assertEquals(Response::HTTP_OK, $result);
    }

    /** @test */
    public function it_sets_the_status_code_to_default_200_when_no_status_code_given()
    {
        $this->response->setStatusCode();

        $result = $this->response->getStatusCode();

        $this->assertEquals(Response::HTTP_OK, $result);
    }

    /** @test */
    public function it_sets_the_status_code_to_the_response()
    {
        $this->response->setStatusCode(Response::HTTP_ALREADY_REPORTED);

        $result = $this->response->getStatusCode();

        $this->assertEquals(Response::HTTP_ALREADY_REPORTED, $result);
    }

    /** @test */
    public function it_returns_the_response_header()
    {
        $result = $this->response->getHeaders();

        $this->assertEquals(['Content-Type' => self::CONTENT_TYPE], $result);
    }

    /** @test */
    public function it_sets_the_response_headers()
    {
        $this->response->setHeaders(['Accept' => 'application/json']);

        $result = $this->response->getHeaders();

        $this->assertEquals([
            'Content-Type' => self::CONTENT_TYPE,
            'Accept' => 'application/json'
        ], $result);
    }

    /** @test */
    public function it_sets_the_meta()
    {
        $result = $this->response->withMeta();

        $this->assertInstanceOf(AbstractApiResponse::class, $result);
        $this->assertEquals([], $result->getMeta());
    }

    /** @test */
    public function it_returns_the_meta()
    {
        $result = $this->response->getMeta();

        $this->assertEquals([], $result);
    }

    /** @test */
    public function it_output_message_to_json()
    {
        $result = $this->response->outputToJson(['entityname' => 'attributes']);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('attributes', $result->getData()->entityname);
    }
}
