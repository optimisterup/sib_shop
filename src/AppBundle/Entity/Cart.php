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
     * @ORM\ManyToOne(targetEntity="CartProduct", inversedBy="carts")
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

//    /**
//     * @param $user
//     */
//    public function setUser($user)
//    {
//        $this->user = $user;
//    }

//    /**
//     * @return mixed
//     */
//    public function getUser()
//    {
//        return $this->user;
//    }
//
//    public function __toString()
//    {
//        return (string) $this->user;
//    }

//    /**
//     * @param mixed $products
//     * @return Cart
//     */
//    public function setProducts($products)
//    {
//        $this->products = $products;
//        return $this;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getProducts()
//    {
//        return $this->products;
//    }

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


}
