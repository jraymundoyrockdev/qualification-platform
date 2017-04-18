<?php

namespace App\Adapters;

use Illuminate\Auth\AuthManager;
use Tymon\JWTAuth\Providers\Auth\AuthInterface;

/**
 * @codeCoverageIgnore
 */
class CustomIlluminateAuthAdapter implements AuthInterface
{
    /**
     * @var AuthManager
     */
    protected $auth;

    /**
     * CustomIlluminateAuthAdapter constructor.
     *
     * @param AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Check a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function byCredentials(array $credentials = [])
    {
        return $this->auth->once($credentials);
    }

    /**
     * Authenticate a user via the id.
     *
     * @param  mixed $id
     * @return bool
     */
    public function byId($id)
    {
        //return $this->auth->onceUsingId($id);
        return $this->user();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->auth->user();
    }
}
