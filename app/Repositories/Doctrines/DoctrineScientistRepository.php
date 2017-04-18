<?php

namespace App\Repositories\Doctrines;

use App\Repositories\Contracts\ScientistRepository;

class DoctrineScientistRepository extends DoctrineRepository implements ScientistRepository
{
    public function someMethodOnlyDesignedForScientist()
    {
    }
}
