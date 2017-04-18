<?php

namespace App\Users;

use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(name="created_at", nullable=true, type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
