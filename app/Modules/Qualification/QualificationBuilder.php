<?php

namespace App\Modules\Qualification;

use Ramsey\Uuid\Uuid;

class QualificationBuilder
{
    /**
     * @var \App\Modules\Qualification\Qualification
     */
    private $qualification;

    public function __construct(Qualification $qualification)
    {
        $this->qualification = $qualification;
    }

    public function build()
    {
        return $this->qualification;
    }

    public function buildInformation($code, $title, $description, $packagingRules, $currencyStatus)
    {
        $this->qualification->setId(Uuid::uuid4());

        $this->qualification->setCode($code);
        $this->qualification->setTitle($title);
        $this->qualification->setDescription($description);
        $this->qualification->setPackagingRules($packagingRules);
        $this->qualification->setCurrencyStatus($currencyStatus);

        return $this;
    }

    public function buildCourseDelivery($onlineLearningStatus, $rplStatus)
    {
        $this->qualification->setOnlineLearningStatus($onlineLearningStatus);
        $this->qualification->setRplStatus($rplStatus);

        return $this;
    }

    public function buildOtherInformation($aqfLevel, $status, $expirationDate, $createdBy)
    {
        $this->qualification->setAqfLevel($aqfLevel);
        $this->qualification->setStatus($status);
        $this->qualification->setExpirationDate($expirationDate);
        $this->qualification->setCreatedBy($createdBy);

        return $this;
    }
}
