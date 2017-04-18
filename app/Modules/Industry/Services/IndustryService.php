<?php

namespace App\Modules\Industry\Services;

use App\Repositories\Contracts\IndustryRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;

class IndustryService extends AbstractModuleService
{
    use RequestResolver;

    /**
     * IndustryService constructor.
     *
     * @param IndustryRepository $industry
     */
    public function __construct(IndustryRepository $industry)
    {
        parent::__construct($industry);
    }
}
