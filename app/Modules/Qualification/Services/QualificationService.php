<?php

namespace App\Modules\Qualification\Services;

use App\Modules\Qualification\Qualification;
use App\Modules\Qualification\QualificationBuilder;
use App\Repositories\Contracts\QualificationRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;
use App\Services\ModuleServiceInterface;
use App\Services\Sync\TGASOAP;

class QualificationService extends AbstractModuleService
{
    use RequestResolver;

    const HTML_URL = 'http://training.gov.au/Training/Details/';

    protected $soapClient;
    protected $qualificationBuilder;
    protected $qualification;

    /**
     * QualificationService constructor.
     * @param QualificationRepository $qualification
     * @param TGASOAP $soapClient
     */
    public function __construct(
        QualificationRepository $qualification,
        TGASOAP $soapClient,
        QualificationBuilder $qualificationBuilder
    ) {
        parent::__construct($qualification);

        $this->soapClient = $soapClient;
        $this->qualificationBuilder = $qualificationBuilder;
        $this->qualification = $qualification;
    }

    /**
     * @param array $input
     *
     * @return Qualification
     */
    public function insert($qualification)
    {
        $qualification = $this->qualificationBuilder->buildInformation(
            $qualification['code'],
            $qualification['title'],
            $qualification['description'],
            $qualification['packaging_rules'],
            $qualification['currency_status']
        )->buildCourseDelivery(
            $qualification['online_learning_status'],
            $qualification['rpl_status']
        )->buildOtherInformation(
            $qualification['aqf_level'],
            $qualification['status'],
            $qualification['expiration_date'],
            $qualification['created_by']
        )->build();

        return $this->qualification->create($qualification);
    }
}
