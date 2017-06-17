<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Response\ApiResponse;
use App\Http\Response\ErrorResponse;
use App\Http\Response\FractalResponse;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;
use JWTFactory;
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

        $user = $this->auth->user();

        $customClaims = [
            'username' => $user->getUsername(),
            'firstname' => $user->getFirstname(),
            'middlename' => $user->getMiddlename(),
            'lastname' => $user->getLastname(),
            'role' => $user->getRole()
        ];

        $token = JWTAuth::fromUser($this->auth->user(), $customClaims);

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
