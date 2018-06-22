<?php
namespace AppBundle\PayPal;
use AppBundle\Entity\User;

/**
 * Class Payment
 * @package AppBundle\PayPal
 * @ORM\Entity
 * @ORM\Table(name="payment")
 */
class Payment
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="cart", referencedColumnName="id")
     */
    private $cart;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $cart
     * @return Payment
     */
    public function setCart(User $cart)
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