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

    public function buildMainInformation($code, $title, $description, $subjectInformation, $currencyStatus, $status='active')
    {
        $this->id = Uuid::uuid4();


        $this->qualifcation->setCode($code);
        $this->qualifcation->setTitle($title);
        $this->description = $description;
        $this->subject_information = $subjectInformation;
        $this->currency_status = $currencyStatus;
        $this->status = $status;
    }

    public function buildCourseDelivery($isOnlineLearning = true, $isRPL = true)
    {

    }

    public function buildRPLPricing($rplCost = 0, $traditionalStudy = 0, $customerSavings = 0)
    {

    }
}
