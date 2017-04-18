<?php

use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Http\Response\FractalResponse;

class ApiResponseTest extends BaseTestCase
{
    protected $apiResponse;

    public function setUp()
    {
        parent::setUp();

        $this->apiResponse = $this->app->make(ApiResponse::class);
    }

    /** @test */
    public function it_returns_an_instance_of_fractal_response()
    {
        $result = $this->apiResponse->fractal();

        $this->assertInstanceOf(FractalResponse::class, $result);
    }

    /** @test */
    public function it_returns_an_instance_of_error_response()
    {
        $result = $this->apiResponse->error();

        $this->assertInstanceOf(ErrorResponse::class, $result);
    }
}