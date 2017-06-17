<?php

namespace App\Modules\User\Services;

use App\Users\User;
use App\Repositories\Contracts\UserRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;
use App\Services\ModuleServiceInterface;
use Illuminate\Hashing\BcryptHasher;
use App\Exceptions\UsernameNotAvailableException;

class UserService extends AbstractModuleService implements ModuleServiceInterface
{
    use RequestResolver;

    protected $hasher;

    public function __construct(BcryptHasher $hasher, UserRepository $user)
    {
        $this->hasher = $hasher;

        parent::__construct($user);
    }

    /**
     * @param array $input
     *
     * @return Assessor
     */
    public function insert($input)
    {
        $attributes = $this->filterRequestAttributes($input);

        $user = $this->repository->findOneBy(['username' => $attributes['username']]);

        if ($user) {
            throw new UsernameNotAvailableException();
        }

        $user = (new User)->factory(
            $attributes['username'],
            $this->hashPassword($attributes['password']),
            $attributes['firstname'],
            $attributes['middlename'],
            $attributes['lastname'],
            $attributes['role']
        );

        return $this->repository->create($user);
    }

    /**
     * @param array $input
     *
     * @return Assessor
     */
    public function update($entity, $input)
    {

    }

    private function hashPassword($password)
    {
        return $this->hasher->make($password);
    }
}
