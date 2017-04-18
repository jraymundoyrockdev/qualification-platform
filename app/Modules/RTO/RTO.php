<?php

namespace App\Modules\RTO;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="rto")
 */
class RTO
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true, length=11)
     */
    protected $code;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $email;

    /**
     * @ORM\Column(type="text", length=1, nullable=true)
     */
    protected $signed;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $rating_price;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $rating_speed;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $rating_efficiency;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $rating_professionalism;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    protected $user_comments;

    /**
     * @ORM\Column(type="text", length=1, nullable=true)
     */
    protected $hidden;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $contact;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $form;

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
     * RTO constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return RTO
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
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
     * @return RTO
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
     * Set signed
     *
     * @param string $signed
     *
     * @return RTO
     */
    public function setSigned($signed)
    {
        $this->signed = $signed;

        return $this;
    }

    /**
     * Get signed
     *
     * @return string
     */
    public function getSigned()
    {
        return $this->signed;
    }

    /**
     * Set userComments
     *
     * @param string $userComments
     *
     * @return RTO
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
     * Set ratingPrice
     *
     * @param integer $ratingPrice
     *
     * @return RTO
     */
    public function setRatingPrice($ratingPrice)
    {
        $this->rating_price = $ratingPrice;

        return $this;
    }

    /**
     * Get ratingPrice
     *
     * @return integer
     */
    public function getRatingPrice()
    {
        return $this->rating_price;
    }

    /**
     * Set ratingSpeed
     *
     * @param integer $ratingSpeed
     *
     * @return RTO
     */
    public function setRatingSpeed($ratingSpeed)
    {
        $this->rating_speed = $ratingSpeed;

        return $this;
    }

    /**
     * Get ratingSpeed
     *
     * @return integer
     */
    public function getRatingSpeed()
    {
        return $this->rating_speed;
    }

    /**
     * Set ratingEfficiency
     *
     * @param integer $ratingEfficiency
     *
     * @return RTO
     */
    public function setRatingEfficiency($ratingEfficiency)
    {
        $this->rating_efficiency = $ratingEfficiency;

        return $this;
    }

    /**
     * Get ratingEfficiency
     *
     * @return integer
     */
    public function getRatingEfficiency()
    {
        return $this->rating_efficiency;
    }

    /**
     * Set ratingProfessionalism
     *
     * @param integer $ratingProfessionalism
     *
     * @return RTO
     */
    public function setRatingProfessionalism($ratingProfessionalism)
    {
        $this->rating_professionalism = $ratingProfessionalism;

        return $this;
    }

    /**
     * Get ratingProfessionalism
     *
     * @return integer
     */
    public function getRatingProfessionalism()
    {
        return $this->rating_professionalism;
    }

    /**
     * Set hidden
     *
     * @param string $hidden
     *
     * @return RTO
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return string
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return RTO
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
     * Set phone
     *
     * @param string $phone
     *
     * @return RTO
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return RTO
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return RTO
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set form
     *
     * @param string $form
     *
     * @return RTO
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return string
     */
    public function getForm()
    {
        return $this->form;
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
