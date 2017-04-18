<?php

namespace App\Modules\Package\Services;

use App\Repositories\Contracts\PackageRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;

class PackageService extends AbstractModuleService
{
    use RequestResolver;

    /**
     * OccupationService constructor.
     *
     * @param PackageRepository $package
     */
    public function __construct(PackageRepository $package)
    {
        parent::__construct($package);
    }
}
