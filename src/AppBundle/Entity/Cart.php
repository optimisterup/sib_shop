<?php
namespace AppBundle\Entity;

use AppBundle\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cart")
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="carts")
     */
    private $cart;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="cart")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="Orders", inversedBy="cart")
     * @ORM\JoinColumn(name="orders", referencedColumnName="id")
     */
    private $orders;

    public function __construct()
    {
        $this->cart=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $cart
     * @return Cart
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

    /**
     * @param mixed $user
     * @return Cart
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @param Orders $orders
     * @return $this
     */
    public function setOrders(Orders $orders)
    {
        $orders->setCart($this);
        $this->orders = $orders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

}
