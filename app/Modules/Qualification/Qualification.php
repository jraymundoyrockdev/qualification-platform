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
     * @ORM\Column(type="text")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $subject_information;

    /**
     * @ORM\Column(type="text", options={"default":"no"})
     */
    protected $is_superseded;

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
    public function __construct($code, $title, $description, $subjectInformation, $isSuperseded = 'no')
    {
        $this->id = Uuid::uuid4();

        $this->code = $code;
        $this->title = $title;
        $this->description = $description;
        $this->subject_information = $subjectInformation;
        $this->is_superseded = $isSuperseded;
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
     * Set subjectInformation
     *
     * @param string $subjectInformation
     *
     * @return Qualification
     */
    public function setSubjectInformation($subjectInformation)
    {
        $this->subject_information = $subjectInformation;

        return $this;
    }

    /**
     * Get subjectInformation
     *
     * @return string
     */
    public function getSubjectInformation()
    {
        return $this->subject_information;
    }

    /**
     * Set isSuperseded
     *
     * @param bool $isSuperseded
     *
     * @return Qualification
     */
    public function setIsSuperseded($isSuperseded)
    {
        $this->is_superseded = $isSuperseded;

        return $this;
    }

    /**
     * Get isSuperseded
     *
     * @return string
     */
    public function getIsSuperseded()
    {
        return $this->is_superseded;
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
