<?php

use App\Http\Middleware\RefreshJWTMiddleware;
use App\Users\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Faker\Factory as Faker;

class RefreshJWTMiddlewareTest extends BaseTestCase
{
    protected $middleware;
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->app->make(Request::class);
        $this->middleware = $this->app->make(RefreshJWTMiddleware::class);
    }

    /** @test */
    public function it_throws_an_error_when_refresh_request_does_not_contain_token()
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
    public function it_returns_next_on_successful_token_validation()
    {
        Artisan::call('doctrine:schema:create');

        $user = $this->prepareUser();

        $token = JWTAuth::fromUser($user);

        $this->request->headers->set('Authorization', 'Bearer ' . $token);

        $result = $this->middleware->handle($this->request, (function () {
            return 'next';
        }));

        $decodedResult = $this->getJsonSchemaResult($result->getContent());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertArrayHasKey('token', $decodedResult);
    }

    /**
     * @return User
     */
    private function prepareUser()
    {
        $faker = Faker::create();
        $hasher = new BcryptHasher;

        $password = $faker->word;
        $hashedPassword = $hasher->make($password);

        return entity(User::class)->create(['id' => Uuid::uuid4(), 'password' => $hashedPassword]);
    }
}
