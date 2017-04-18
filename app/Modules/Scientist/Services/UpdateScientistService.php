<?php

namespace App\Modules\Scientist\Services;

use App\Repositories\Contracts\ScientistRepository;
use App\Resolvers\RequestResolver;

class UpdateScientistService
{
    use RequestResolver;

    /**
     * @var ScientistRepository
     */
    private $repository;

    /**
     * CreateScientistService constructor.
     *
     * @param ScientistRepository $repository
     */
    public function __construct(ScientistRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param object $entity
     * @param array $input
     * @return object
     */
    public function update($entity, $input)
    {
        $attributes = $this->filterRequestAttributes($input);

        $entity->setFirstName($attributes['firstname']);
        $entity->setLastName($attributes['lastname']);

        $this->repository->update();

        return $entity;
    }
}
