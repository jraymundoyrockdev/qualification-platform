<?php

namespace App\Modules\AssessorCourse;

use App\Modules\Assessor\Assessor;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="assessor_course")
 */
class AssessorCourse
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Modules\Assessor\Assessor", inversedBy="assessor_course")
     * @ORM\JoinColumn(name="assessor_id", referencedColumnName="id")
     * @var Assessor
     */
    protected $assessor;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $course_code;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $cost;

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
     * Course constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
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
     * Set assessor
     *
     * @param Assessor|null $assessor
     *
     * @return $this
     */
    public function setAssessor(Assessor $assessor = null)
    {
        $this->assessor = $assessor;

        return $this;
    }

    /**
     * Get assessor
     *
     * @return \App\Modules\Assessor\Assessor
     */
    public function getAssessor()
    {
        return $this->assessor;
    }

    /**
     * Set courseCode
     *
     * @param string $courseCode
     *
     * @return AssessorCourse
     */
    public function setCourseCode($courseCode)
    {
        $this->course_code = $courseCode;

        return $this;
    }

    /**
     * Get courseCode
     *
     * @return string
     */
    public function getCourseCode()
    {
        return $this->course_code;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return AssessorCourse
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AssessorCourse
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
     * @return AssessorCourse
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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
