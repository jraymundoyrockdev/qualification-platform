<?php

namespace App\Modules\Assessor;

use App\Modules\AssessorCourse\AssessorCourse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="assessor")
 */
class Assessor
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=256)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", length=256)
     */
    protected $email;

    /**
     * @ORM\Column(type="text", length=50)
     */
    protected $mobile;

    /**
     * @ORM\Column(type="text", length=256)
     */
    protected $notes;

    /**
     * @ORM\Column(type="text", length=50)
     */
    protected $type;

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
     * @ORM\OneToMany(targetEntity="App\Modules\AssessorCourse\AssessorCourse", mappedBy="assessor", cascade={"persist"})
     * @var ArrayCollection|AssessorCourse[]
     */
    protected $assessor_course;

    /**
     * Assessor constructor.
     *
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @param string $notes
     * @param string $type
     */
    public function __construct($name, $email, $mobile, $notes, $type)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->notes = $notes;
        $this->type = $type;

        $this->assessor_course = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Assessor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Assessor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Assessor
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Assessor
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Assessor
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AssessorCourse $assessorCourse
     *
     * @return $this
     */
    public function addAssessorCourse(AssessorCourse $assessorCourse)
    {
        $this->assessor_course[] = $assessorCourse;

        return $this;
    }

    /**
     * Remove assessorCourse
     *
     * @param \App\Modules\AssessorCourse\AssessorCourse $assessorCourse
     */
    public function removeAssessorCourse(AssessorCourse $assessorCourse)
    {
        $this->assessor_course->removeElement($assessorCourse);
    }

    /**
     * Get assessorCourse
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssessorCourse()
    {
        return $this->assessor_course;
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
