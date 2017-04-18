<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Http\Response\FractalResponse;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends ApiController
{
    /**
     * @var Guard
     */
    protected $auth;
    /**
     * @var ApiResponse
     */
    private $response;

    /**
     * AuthenticationController constructor.
     *
     * @param Guard $auth
     * @param ApiResponse $response
     */
    public function __construct(Guard $auth, ApiResponse $response)
    {
        $this->auth = $auth;
        $this->response = $response;
    }

    /**
     * @return FractalResponse|ErrorResponse
     */
    public function authenticate()
    {
        if (!$this->auth->user()) {
            return $this->response->error()->respondUnprocessableEntity('Invalid Credentials.');
        }

        $token = JWTAuth::fromUser($this->auth->user());

        return $this->response->fractal()->outputToJson(['token' => $token]);
    }

    /**
     * @codeCoverageIgnore
     *
     * Refresh token is handled by the middleware
     */
    public function refreshToken()
    {
        return;
    }
}
