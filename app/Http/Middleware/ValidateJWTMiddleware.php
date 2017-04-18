<?php

namespace App\Http\Middleware;

use App\Http\Response\ApiResponse;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ValidateJWTMiddleware
{
    /**
     * @var ApiResponse
     */
    private $response;

    /**
     * ValidateJWTMiddleware constructor.
     *
     * @param ApiResponse $response
     * @internal param JWTAuth $auth
     */
    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $exception) {
            return $this->response->error()->respondInvalidJWT($exception->getMessage());
        } catch (TokenExpiredException $exception) {
            return $this->response->error()->respondExpiredJWT($exception->getMessage());
        } catch (JWTException $exception) {
            return $this->response->error()->respondMissingJWT($exception->getMessage());
        }

        return $next($request);
    }
}
