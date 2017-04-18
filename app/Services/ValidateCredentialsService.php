<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepository;
use Illuminate\Hashing\BcryptHasher;

class ValidateCredentialsService
{
    /**
     * @var BcryptHasher
     */
    protected $hasher;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ValidateCredentials constructor.
     * @param BcryptHasher $hasher
     */
    public function __construct(BcryptHasher $hasher, UserRepository $user)
    {
        $this->hasher = $hasher;
        $this->user = $user;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return false|UserRepository
     */
    public function authenticate($username, $password)
    {
        if (!$user = $this->findUser($username)) {
            return false;
        }

        if (!$this->validatePassword($password, $user->getPassword())) {
            return false;
        }

        return $user;
    }

    /**
     * @param string $username
     */
    private function findUser($username)
    {
        return $this->user->findOneBy(['username' => $username]);
    }

    /**
     * @param string $inputPassword
     * @param string $storedDbPassword
     *
     * @return bool
     */
    private function validatePassword($inputPassword, $storedDbPassword)
    {
        return $this->hasher->check($inputPassword, $storedDbPassword);
    }
}
