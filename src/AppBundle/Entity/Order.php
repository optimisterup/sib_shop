<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

//    private $user;
//
//    private $products;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="OrderDelivary", inversedBy="Order")
//     * @ORM\JoinColumn(name="delivary",referencedColumnName="id")
//     */
//    private $delivary;
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
//     * @param $user
//     */
//    public function setUser($user)
//    {
//        $this->user = $user;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getUser()
//    {
//        return $this->user;
//    }
//
//    /**
//     * @param $products
//     */
//    public function setProducts($products)
//    {
//        $this->products = $products;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getProducts()
//    {
//        return $this->products;
//    }
//
//    public function __toString()
//    {
//        return (string) $this->user;
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
