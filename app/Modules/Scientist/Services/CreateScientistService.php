<?php

namespace App\Modules\Scientist\Services;

use App\Modules\Scientist\ScientistFactory;
use App\Modules\Theory\TheoryFactory;
use App\Repositories\Contracts\ScientistRepository;
use App\Resolvers\RequestResolver;

class CreateScientistService
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
     * Inserts new Scientist
     *
     * @param array $input
     *
     * @return array
     */
    public function insert($input)
    {
        $attributes = $this->filterRequestAttributes($input);
        $theory = $this->filterRequestRelationships($input, 'theory');

        $scientist = ScientistFactory::create($attributes['firstname'], $attributes['lastname']);
        $scientist->addTheory(TheoryFactory::create($theory['title']));

        return $this->repository->create($scientist);
    }
}
