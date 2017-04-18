<?php

namespace App\Services;

interface ModuleServiceInterface
{
    /**
     * @param array $payload
     *
     * @return mixed
     */
    public function insert($payload);

    /**
     * @param object $entity
     * @param array $input
     *
     * @return mixed
     */
    public function update($entity, $input);
}
