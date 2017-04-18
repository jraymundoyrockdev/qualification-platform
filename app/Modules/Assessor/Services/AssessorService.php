<?php

namespace App\Modules\Assessor\Services;

use App\Modules\Assessor\Assessor;
use App\Modules\Assessor\AssessorFactory;
use App\Repositories\Contracts\AssessorRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;
use App\Services\ModuleServiceInterface;

class AssessorService extends AbstractModuleService implements ModuleServiceInterface
{
    use RequestResolver;

    /**
     * CreateAssessorService constructor.
     * @param AssessorRepository $assessor
     */
    public function __construct(AssessorRepository $assessor)
    {
        parent::__construct($assessor);
    }

    /**
     * @param array $input
     *
     * @return Assessor
     */
    public function insert($input)
    {
        $attributes = $this->filterRequestAttributes($input);

        $assessor = AssessorFactory::factory(
            $attributes['name'],
            $attributes['email'],
            $attributes['mobile'],
            $attributes['notes'],
            $attributes['type']
        );

        return $this->repository->create($assessor);
    }

    /**
     * @param object $entity
     * @param array $input
     *
     * @return Assessor
     */
    public function update($entity, $input)
    {
        $attributes = $this->filterRequestAttributes($input);

        $entity->setName($attributes['name']);
        $entity->setEmail($attributes['email']);
        $entity->setMobile($attributes['mobile']);
        $entity->setNotes($attributes['notes']);
        $entity->setType($attributes['type']);

        $this->repository->update();

        return $entity;
    }

    public function course()
    {
       // $this->repository->get
    }
}
