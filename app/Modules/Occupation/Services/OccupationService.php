<?php

namespace App\Modules\Occupation\Services;

use App\Repositories\Contracts\OccupationRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;

class OccupationService extends AbstractModuleService
{
    use RequestResolver;

    /**
     * OccupationService constructor.
     *
     * @param OccupationRepository $occupation
     */
    public function __construct(OccupationRepository $occupation)
    {
        parent::__construct($occupation);
    }
}
