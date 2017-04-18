<?php

use App\Http\Middleware\ValidateJWTMiddleware;
use App\Users\User;
use Faker\Factory as Faker;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidateJWTMiddlewareTest extends BaseTestCase
{
    protected $request;
    protected $middleware;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->app->make(Request::class);
        $this->middleware = $this->app->make(ValidateJWTMiddleware::class);
    }

    /** @test */
    public function it_throws_an_error_when_request_does_not_contain_token()
    {
        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Internal Server Error', $decodedResult['errors']['title']);
        $this->assertEquals('The token could not be parsed from the request', $decodedResult['errors']['detail']);
    }

    /** @test */
    public function it_throws_an_error_when_request_token_is_invalid()
    {
        $request = $this->request;
        $request->headers->set('Authorization', 'Bearer someInvalidJWT');

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Bad Request', $decodedResult['errors']['title']);
        $this->assertEquals('Wrong number of segments', $decodedResult['errors']['detail']);
    }

    /** @test */
    public function it_throws_an_error_when_request_token_is_expired()
    {
        $expiredToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJiZDA0NTk1Mi1mM2ZmLTQwYWMtYjkyZi04YjE4MWQ2NTQ0MzMiLCJpc3MiOiJodHRwOlwvXC9xdWFsaWZpY2F0aW9uLXBsYXRmb3JtLWFwaS5kZXZcL2FwaVwvYXBpLXRva2VuLWF1dGgiLCJpYXQiOjE0ODE1MjAxMDAsImV4cCI6MTQ4MTUyMDE2MCwibmJmIjoxNDgxNTIwMTAwLCJqdGkiOiJiODc2MjBhYjIwNTM4NzFjMDFlNzU2YTc1NzgzMTc2YiJ9.M-NsEWdg0VOZBAadNSW_tykR7MMYf-4-Czvw1hw4Cuk';

        $request = $this->request;
        $request->headers->set('Authorization', 'Bearer ' . $expiredToken);

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('Unauthorized', $decodedResult['errors']['title']);
        $this->assertEquals('Token has expired', $decodedResult['errors']['detail']);
    }

    /** @test */
    public function it_returns_next_on_successful_token_validation()
    {
        Artisan::call('doctrine:schema:create');

        $faker = Faker::create();
        $hasher = new BcryptHasher;

        $password = $faker->word;
        $hashedPassword = $hasher->make($password);
        $user = entity(User::class)->create(['id' => Uuid::uuid4(), 'password' => $hashedPassword]);

        $token = JWTAuth::fromUser($user);

        $request = $this->request;
        $request->headers->set('Authorization', 'Bearer ' . $token);

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $this->assertEquals('next', $result);
    }
}
