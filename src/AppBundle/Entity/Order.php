<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") */
    private $paymentInstruction;

    /** @ORM\Column(type="decimal", precision=10, scale=5) */
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }

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
