<?php

namespace App\Modules\RTO;

class RTOBuilder
{
    /**
     * @var \App\Modules\RTO\RTO
     */
    private $rto;

    /**
     * RTOBuilder constructor.
     * @param \App\Modules\RTO\RTO $rto
     */
    public function __construct(RTO $rto)
    {
        $this->rto = $rto;
    }

    public function build()
    {
        return $this->rto;
    }

    public function createPrimaryInformation($code, $name, $email)
    {
        $this->rto->setCode($code);
        $this->rto->setName($name);
        $this->rto->setEmail($email);
    }

    public function createRatings($efficiency, $price, $professionalism, $speed)
    {
        $this->rto->setRatingEfficiency($efficiency);
        $this->rto->setRatingPrice($price);
        $this->rto->setRatingProfessionalism($professionalism);
        $this->rto->setRatingSpeed($speed);
    }

    public function createOtherInformation($signed, $comments, $hidden, $phone, $website, $contact, $form)
    {
        $this->rto->setSigned($signed);
        $this->rto->setUserComments($comments);
        $this->rto->setHidden($hidden);
        $this->rto->setPhone($phone);
        $this->rto->setWebsite($website);
        $this->rto->setContact($contact);
        $this->rto->setForm($form);
    }
}
