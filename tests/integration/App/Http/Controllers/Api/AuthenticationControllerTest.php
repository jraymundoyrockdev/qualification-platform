<?php

use App\Users\User;
use Faker\Factory as Faker;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationControllerTest extends BaseTestCase
{
    protected $hasher;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('doctrine:schema:create');

        $this->hasher = $this->app->make(BcryptHasher::class);
    }

    /**
     * @test
     */
    public function it_returns_an_invalid_response_if_username_is_invalid_or_does_not_exist()
    {
        $this->post('/api/api-token-auth', ['username' => 'invalidUsername', 'invalidPassword']);

        $result = $this->getContent();
        $this->assertEquals('Invalid Credentials.', $result->errors->detail);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function it_returns_an_invalid_response_if_password_is_incorrect()
    {
        $faker = Faker::create();

        $password = $this->hasher->make($faker->word);
        $user = entity(User::class)->create(['id' => Uuid::uuid4(), 'password' => $password]);

        $this->post('/api/api-token-auth', ['username' => $user->getUsername(), 'password' => 'invalidPassword']);

        $result = $this->getContent();
        $this->assertEquals('Invalid Credentials.', $result->errors->detail);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function it_returns_a_valid_token_response()
    {
        $faker = Faker::create();

        $password = $faker->word;
        $hashedPassword = $this->hasher->make($password);
        $user = entity(User::class)->create(['id' => Uuid::uuid4(), 'password' => $hashedPassword]);

        $this->post('/api/api-token-auth', ['username' => $user->getUsername(), 'password' => $password]);

        $this->assertResponseOk();
    }
}
