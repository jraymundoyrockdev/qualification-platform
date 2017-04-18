<?php

namespace App\Modules\Course;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="course")
 */
class Course
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
     * @ORM\Column(type="text", length=128)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", length=10)
     */
    protected $level;

    /**
     * @ORM\Column(type="text", length=256)
     */
    protected $training_package;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $selling_price;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $initial_price;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $best_market_price;

    /**
     * @ORM\Column(type="text")
     */
    protected $user_comments;

    /**
     * @ORM\Column(type="text")
     */
    protected $target_market;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $times_completed;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $active;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $status;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $online;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $trades;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $faculty;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $is_mapped;

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
     * Set code
     *
     * @param string $code
     *
     * @return Course
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
     * Set name
     *
     * @param string $name
     *
     * @return Course
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
     * Set level
     *
     * @param string $level
     *
     * @return Course
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set trainingPackage
     *
     * @param string $trainingPackage
     *
     * @return Course
     */
    public function setTrainingPackage($trainingPackage)
    {
        $this->training_package = $trainingPackage;

        return $this;
    }

    /**
     * Get trainingPackage
     *
     * @return string
     */
    public function getTrainingPackage()
    {
        return $this->training_package;
    }

    /**
     * Set sellingPrice
     *
     * @param integer $sellingPrice
     *
     * @return Course
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->selling_price = $sellingPrice;

        return $this;
    }

    /**
     * Get sellingPrice
     *
     * @return integer
     */
    public function getSellingPrice()
    {
        return $this->selling_price;
    }

    /**
     * Set initialPrice
     *
     * @param integer $initialPrice
     *
     * @return Course
     */
    public function setInitialPrice($initialPrice)
    {
        $this->initial_price = $initialPrice;

        return $this;
    }

    /**
     * Get initialPrice
     *
     * @return integer
     */
    public function getInitialPrice()
    {
        return $this->initial_price;
    }

    /**
     * Set bestMarketPrice
     *
     * @param integer $bestMarketPrice
     *
     * @return Course
     */
    public function setBestMarketPrice($bestMarketPrice)
    {
        $this->best_market_price = $bestMarketPrice;

        return $this;
    }

    /**
     * Get bestMarketPrice
     *
     * @return integer
     */
    public function getBestMarketPrice()
    {
        return $this->best_market_price;
    }

    /**
     * Set userComments
     *
     * @param string $userComments
     *
     * @return Course
     */
    public function setUserComments($userComments)
    {
        $this->user_comments = $userComments;

        return $this;
    }

    /**
     * Get userComments
     *
     * @return string
     */
    public function getUserComments()
    {
        return $this->user_comments;
    }

    /**
     * Set targetMarket
     *
     * @param string $targetMarket
     *
     * @return Course
     */
    public function setTargetMarket($targetMarket)
    {
        $this->target_market = $targetMarket;

        return $this;
    }

    /**
     * Get targetMarket
     *
     * @return string
     */
    public function getTargetMarket()
    {
        return $this->target_market;
    }

    /**
     * Set timesCompleted
     *
     * @param integer $timesCompleted
     *
     * @return Course
     */
    public function setTimesCompleted($timesCompleted)
    {
        $this->times_completed = $timesCompleted;

        return $this;
    }

    /**
     * Get timesCompleted
     *
     * @return integer
     */
    public function getTimesCompleted()
    {
        return $this->times_completed;
    }

    /**
     * Set active
     *
     * @param string $active
     *
     * @return Course
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Course
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
     * Set online
     *
     * @param string $online
     *
     * @return Course
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return string
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set trades
     *
     * @param integer $trades
     *
     * @return Course
     */
    public function setTrades($trades)
    {
        $this->trades = $trades;

        return $this;
    }

    /**
     * Get trades
     *
     * @return integer
     */
    public function getTrades()
    {
        return $this->trades;
    }

    /**
     * Set faculty
     *
     * @param string $faculty
     *
     * @return Course
     */
    public function setFaculty($faculty)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * Get faculty
     *
     * @return string
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set isMapped
     *
     * @param string $isMapped
     *
     * @return Course
     */
    public function setIsMapped($isMapped)
    {
        $this->is_mapped = $isMapped;

        return $this;
    }

    /**
     * Get isMapped
     *
     * @return string
     */
    public function getIsMapped()
    {
        return $this->is_mapped;
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
