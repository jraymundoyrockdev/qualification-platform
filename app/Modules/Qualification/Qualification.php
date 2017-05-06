<?php

namespace App\Modules\Qualification;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="qualification")
 */
class Qualification
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $code;

    /**
     * @ORM\Column(type="text", length=256)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $packaging_rules;

    /**
     * @ORM\Column(type="string", length=100, options={"default":"current"})
     */
    protected $currency_status;

    /**
     * @ORM\Column(type="string",length=100, options={"default":"active"})
     */
    protected $status;

    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $aqf_level;

    /**
     * @ORM\Column(type="string", length=10, options={"default":"active"})
     */
    protected $online_learning_status;

    /**
     * @ORM\Column(type="string", length=10, options={"default":"active"})
     */
    protected $rpl_status;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $expiration_date;

    /**
     * @ORM\Column(type="string", length=50, nullable = false)
     */
    protected $created_by;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated_at;

    /**
     * Qualification constructor.
     */
    public function __construct()
    {

    }

    /**
     * Set id
     *
     * @param uuid $id
     *
     * @return Qualification
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Qualification
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Qualification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Qualification
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set packagingRules
     *
     * @param string $packagingRules
     *
     * @return Qualification
     */
    public function setPackagingRules($packagingRules)
    {
        $this->packaging_rules = $packagingRules;

        return $this;
    }

    /**
     * Get packagingRules
     *
     * @return string
     */
    public function getPackagingRules()
    {
        return $this->packaging_rules;
    }

    /**
     * Set CurrencyStatus
     *
     * @param bool $currencyStatus
     *
     * @return Qualification
     */
    public function setCurrencyStatus($currencyStatus)
    {
        $this->currency_status = $currencyStatus;

        return $this;
    }

    /**
     * Get currencyStatus
     *
     * @return string
     */
    public function getCurrencyStatus()
    {
        return $this->currency_status;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Qualification
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set aqf_level
     *
     * @param string $aqfLevel
     *
     * @return Qualification
     */
    public function setAqfLevel($aqfLevel)
    {
        $this->aqf_level = $aqfLevel;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getAqfLevel()
    {
        return $this->aqf_level;
    }

    /**
     * Set online_learning_status
     *
     * @param string $onlineLearningStatus
     *
     * @return Qualification
     */
    public function setOnlineLearningStatus($onlineLearningStatus)
    {
        $this->online_learning_status = $onlineLearningStatus;

        return $this;
    }

    /**
     * Get online_learning_status
     *
     * @return string
     */
    public function getOnlineLearningStatus()
    {
        return $this->online_learning_status;
    }

    /**
     * Set rpl_status
     *
     * @param string $rplStatus
     *
     * @return Qualification
     */
    public function setRplStatus($rplStatus)
    {
        $this->rpl_status = $rplStatus;

        return $this;
    }

    /**
     * Get rpl_status
     *
     * @return string
     */
    public function getRplStatus()
    {
        return $this->rpl_status;
    }

    /**
     * Set expirationDate
     *
     * @param string $expirationDate
     *
     * @return Qualification
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expiration_date = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return Qualification
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Qualification
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Qualification
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Gets triggered only on insert
     * @codeCoverageIgnore
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @codeCoverageIgnore
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime("now");
    }

}
