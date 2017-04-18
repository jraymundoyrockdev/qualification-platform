<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    /**
     * A method widely-used by the api
     *
     * @param object $entity
     * @return mixed
     */
    public function create($entity);

    /**
     * @return mixed
     */
    public function update();
}
