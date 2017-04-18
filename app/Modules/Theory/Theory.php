<?php
namespace App\Modules\Theory;

use App\Modules\Scientist\Scientist;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="theory")
 */
class Theory
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
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Modules\Scientist\Scientist", inversedBy="theory")
     * @ORM\JoinColumn(name="scientist_id", referencedColumnName="id")
     * @var Scientist
     */
    protected $scientist;

    /**
     * @param $title
     */
    public function __construct($title)
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setScientist(Scientist $scientist)
    {
        $this->scientist = $scientist;
    }

    public function getScientist()
    {
        return $this->scientist;
    }
}
