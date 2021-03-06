<?php

namespace App\Services;

class AbstractModuleService
{
    protected $repository;

    /**
     * AbstractModuleService constructor.
     *
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function findOneById($id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}
