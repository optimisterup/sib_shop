<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_delivary")
 */
class OrderDelivary
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
//
//    /**
//     * @ORM\OneToMany(targetEntity="Orders", mappedBy="delivary")
//     */
//    private $order;
//
//    /**
//     * @ORM\OneToMany(targetEntity="Delivary", mappedBy="status")
//     */
//    private $delivary;
//
//    public function __construct()
//    {
//        $this->order= new ArrayCollection();
//        $this->delivary= new ArrayCollection();
//    }
//
//    /**
//     * @ORM\Column(type="string")
//     */
//    private $status;
//
//    /**
//     * @return mixed
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getStatus()
//    {
//        return $this->status;
//    }
//
//    /**
//     * @param mixed $status
//     */
//    public function setStatus($status)
//    {
//        $this->status = $status;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getOrder()
//    {
//        return $this->order;
//    }
//
//    /**
//     * @param mixed $order
//     */
//    public function setOrder($order)
//    {
//        $this->order = $order;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getDelivary()
//    {
//        return $this->delivary;
//    }
//
//    /**
//     * @param mixed $delivary
//     */
//    public function setDelivary($delivary)
//    {
//        $this->delivary = $delivary;
//    }
}
