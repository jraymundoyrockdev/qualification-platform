<?php

namespace App\Modules\Unit;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="unit")
 *
 */
class Unit
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=50)
     */
    protected $code;

    /**
     * @ORM\Column(type="text", length=256)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", length=10)
     */
    protected $group_name;

    /**
     * @ORM\Column(type="text", length=10)
     */
    protected $subgroup;

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
     * Unit constructor.
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
     * Set Code
     *
     * @param string $code
     *
     * @return Unit
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return Unit
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set GroupName
     *
     * @param string $groupName
     *
     * @return Unit
     */
    public function setGroupName($groupName)
    {
        $this->group_name = $groupName;

        return $this;
    }

    /**
     * Get GroupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * Set SubGroup
     *
     * @param string $subgroup
     *
     * @return Unit
     */
    public function setSubGroup($subgroup)
    {
        $this->subgroup = $subgroup;

        return $this;
    }

    /**
     * Get SubGroup
     *
     * @return string
     */
    public function getSubGroup()
    {
        return $this->subgroup;
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
