<?php

use App\Http\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponseTest extends BaseTestCase
{
    protected $response;

    public function setUp()
    {
        parent::setUp();

        $this->response = $this->app->make(ErrorResponse::class);
    }

    /** @test */
    public function it_returns_an_error_not_found_response()
    {
        $result = $this->response->respondErrorNotFound();

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND, $result);
    }

    /** @test */
    public function it_returns_a_bad_request_response()
    {
        $result = $this->response->respondBadRequest();

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST, $result);
    }

    /** @test */
    public function it_returns_an_unprocessable_entity_response()
    {
        $result = $this->response->respondUnprocessableEntity();

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY, $result);
    }

    /** @test */
    public function it_returns_a_missing_jwt_response()
    {
        $result = $this->response->respondMissingJWT();

        $this->assertResponseStatus(Response::HTTP_INTERNAL_SERVER_ERROR, $result);
        $this->assertEquals('JWT not found.', $result->getData()->errors->detail);
    }

    /** @test */
    public function it_returns_an_invalid_jwt_response()
    {
        $result = $this->response->respondInvalidJWT();

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST, $result);
        $this->assertEquals('Invalid JWT.', $result->getData()->errors->detail);
    }

    /** @test */
    public function it_returns_a_expired_jwt_response()
    {
        $result = $this->response->respondExpiredJWT();

        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED, $result);
        $this->assertEquals('JWT already expired.', $result->getData()->errors->detail);
    }
}