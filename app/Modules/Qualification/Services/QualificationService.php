<?php

namespace App\Modules\Qualification\Services;

use App\Modules\Qualification\Qualification;
use App\Modules\Qualification\QualificationFactory;
use App\Repositories\Contracts\QualificationRepository;
use App\Resolvers\RequestResolver;
use App\Services\AbstractModuleService;
use App\Services\ModuleServiceInterface;
use App\Services\Sync\TGASOAP;

class QualificationService extends AbstractModuleService implements ModuleServiceInterface
{
    use RequestResolver;

    const HTML_URL = 'http://training.gov.au/Training/Details/';

    protected $soapClient;

    /**
     * QualificationService constructor.
     * @param QualificationRepository $qualification
     * @param TGASOAP $soapClient
     */
    public function __construct(QualificationRepository $qualification, TGASOAP $soapClient)
    {
        parent::__construct($qualification);

        $this->soapClient = $soapClient;
    }

    /**
     * @param array $input
     *
     * @return Qualification
     */
    public function insert($input)
    {
        $attributes = $this->filterRequestAttributes($input);

        $qualification = QualificationFactory::factory(
            $attributes['code'],
            $attributes['title'],
            $attributes['description'],
            $attributes['subject_information'],
            $attributes['currency_status']
        );

        return $this->repository->create($qualification);
    }

    /**
     * @param object $entity
     * @param array $input
     *
     * @return Qualification
     */
    public function update($entity, $input)
    {
        $attributes = $this->filterRequestAttributes($input);

        $entity->setCode($attributes['code']);
        $entity->setTitle($attributes['title']);
        $entity->setDescription($attributes['description']);
        $entity->setSubjectInformation($attributes['subject_information']);
        $entity->setCurrencyStatus($attributes['currency_status']);

        $this->repository->update();

        return $entity;
    }

    public function course()
    {
       // $this->repository->get
    }
}
