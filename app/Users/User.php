<?php

namespace App\Users;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $middlename;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", nullable=false, options={"default": "user"})
     */
    protected $role;

    /**
     * @ORM\Column(name="created_at", nullable=true, type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    public function factory($username, $password, $firstname, $middlename = null, $lastname = null, $role = 'user')
    {
        $this->id = Uuid::uuid4();
        $this->username = $username;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
        $this->role = $role;

        return $this;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $middlename
     *
     * @return User
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;

        return $this;
    }

    /**
     * @return middlename
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return lastname
     */
    public function getRole()
    {
        return $this->role;
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
}
