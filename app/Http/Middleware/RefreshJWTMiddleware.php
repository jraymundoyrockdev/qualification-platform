<?php

namespace App\Http\Middleware;

use App\Http\Response\ApiResponse;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class RefreshJWTMiddleware
{
    /**
     * @var ApiResponse
     */
    private $response;
    /**
     * @var JWTAuth
     */
    private $JWTAuth;

    /**
     * RefreshJWTMiddleware constructor.
     * @param ApiResponse $response
     * @param JWTAuth $JWTAuth
     */
    public function __construct(ApiResponse $response, JWTAuth $JWTAuth)
    {
        $this->response = $response;
        $this->JWTAuth = $JWTAuth;
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
            $newToken = $this->JWTAuth->setRequest($request)->parseToken()->refresh();
        } catch (TokenInvalidException $exception) {
            return $this->response->error()->respondInvalidJWT($exception->getMessage());
        } catch (JWTException $exception) {
            return $this->response->error()->respondMissingJWT($exception->getMessage());
        }

        return $this->response
            ->fractal()
            ->setHeaders(['Authorization' => 'Bearer ' . $newToken])
            ->outputToJson(['token' => $newToken]);
    }
}
