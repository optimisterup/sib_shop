<?php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="order")
     */
    private $transaction;

    /**
     * @ORM\OneToOne(targetEntity="Cart", inversedBy="orders")
     * @ORM\JoinColumn(name="cart", referencedColumnName="id")
     */
    private $cart;


    public function __construct($amount)
    {
        $this->amount = $amount;
        $this->transaction= new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed $transaction
     * @return Orders
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param mixed $cart
     * @return Orders
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }
}