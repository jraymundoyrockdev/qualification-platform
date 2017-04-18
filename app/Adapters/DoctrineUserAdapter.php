<?php

namespace App\Adapters;

use App\Users\User;
use Tymon\JWTAuth\Providers\User\UserInterface;

class DoctrineUserAdapter implements UserInterface
{
    protected $em;

    /**
     * DoctrineUserAdapter constructor.
     *
     * @param User $entityManager
     */
    public function __construct(User $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function getBy($key, $value)
    {
        //return $this->em->find('App\Sistemas\Aplicacao\Base\Models\User', $value);
        /*
         * Note that I'm ignoring $key because it's almost always 'id', but if you
         * have a different jwt.identifier (that isn't your entity identifier) you'll need
         * to do something more complex here, potentially involving a repository.
         *
         * Also the entity class is hard-set in this example, but you could read it
         * from your config or have a setter to make it a more general solution.
         */
    }
}
