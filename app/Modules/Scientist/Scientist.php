<?php
namespace App\Modules\Scientist;

use App\Modules\Theory\Theory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="scientist")
 */
class Scientist
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="App\Modules\Theory\Theory", mappedBy="scientist", cascade={"persist"})
     * @var ArrayCollection|Theory[]
     */
    protected $theory;

    /**
     * Scientist constructor.
     *
     * @param $firstname
     * @param $lastname
     */
    public function __construct($firstname, $lastname)
    {
        $this->id = Uuid::uuid4();
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        $this->theory = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function setLastName($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function addTheory(Theory $theo)
    {
        if (!$this->theory->contains($theo)) {
            $theo->setScientist($this);
            $this->theory->add($theo);
        }
    }

    public function getTheory()
    {
        return $this->theory;
    }
}
