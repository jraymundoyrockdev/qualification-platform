<?php

namespace App\Modules\Unit\Services;

use App\Repositories\Contracts\UnitRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;

class UnitService extends AbstractModuleService
{
    use RequestResolver;

    /**
     * UnitService constructor.
     *
     * @param UnitRepository $unit
     */
    public function __construct(UnitRepository $unit)
    {
        parent::__construct($unit);
    }
}
