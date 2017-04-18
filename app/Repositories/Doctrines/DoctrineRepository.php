<?php

namespace App\Repositories\Doctrines;

use App\Repositories\Contracts\RepositoryInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @param object $entity
     *
     * @return object
     */
    public function create($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     *
     */
    public function update()
    {
        $this->getEntityManager()->flush();
    }
}
