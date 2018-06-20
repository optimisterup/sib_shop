<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="delivery")
 */
class Delivary
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @ORM\ManyToOne(targetEntity="OrderDelivary", inversedBy="delivary")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    private $status;

    /** @ORM\Column(type="decimal", precision=10, scale=2) */
    private $amount;

    public function __construct($amount)
    {
        $this->amount=$amount;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }


}
