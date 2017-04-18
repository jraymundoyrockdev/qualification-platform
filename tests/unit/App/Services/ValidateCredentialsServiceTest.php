<?php

use App\Repositories\Contracts\UserRepository;
use App\Services\ValidateCredentialsService;
use App\Users\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class ValidateCredentialsServiceTest extends BaseTestCase
{
    protected $hasher;
    protected $user;
    protected $validator;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('doctrine:schema:create');

        $this->hasher = $this->app->make(BcryptHasher::class);
        $this->user = $this->app->make(UserRepository::class);
        $this->validator = $this->app->make(ValidateCredentialsService::class);
    }

    /**
     * @test
     */
    public function it_returns_false_when_user_does_not_exist()
    {
        $result = $this->validator->authenticate('unknownUsername', 'unknownPassword');

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function it_returns_false_if_password_is_wrong()
    {
        $faker = Faker::create();

        $password = $this->hasher->make($faker->word);
        $user = entity(User::class)->create(['id' => Uuid::uuid4(), 'password' => $password]);

        $result = $this->validator->authenticate($user->getUsername(), 'unknownPassword');

        $this->assertFalse($result);

    }

    /** @test */
    public function it_returns_user_on_valid_credentials()
    {
        $faker = Faker::create();

        $password = $faker->word;
        $hashedPassword = $this->hasher->make($password);
        $user = entity(User::class)->create(['id' => Uuid::uuid4(), 'password' => $hashedPassword]);

        $result = $this->validator->authenticate($user->getUsername(), $password);


        $this->assertInstanceOf(User::class,$result);
    }
}
