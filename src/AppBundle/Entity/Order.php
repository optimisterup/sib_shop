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

    /** @ORM\Column(type="decimal", precision=10, scale=2) */
    private $amount;

    /**
    * @ORM\OneToMany(targetEntity="TransactionOrder", mappedBy="order")
    */
    private $transaction;

    /**
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="order")
     */
    private $cartProduct;

    public function __construct($amount)
    {
        $this->amount = $amount;
        $this->transaction= new ArrayCollection();
        $this->cartProduct= new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

}
