<?php

namespace App\Repositories\Doctrines;

use App\Repositories\Contracts\TheoryRepository;

class DoctrineTheoryRepository extends DoctrineRepository implements TheoryRepository
{
    public function someMethodOnlyDesignedForTheory()
    {
    }
}
