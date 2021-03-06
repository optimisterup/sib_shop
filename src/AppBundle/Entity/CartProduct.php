<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cart_product_cross")
 */
class CartProduct
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="cart" , cascade={"persist","remove"})
     * @ORM\JoinColumn(name="carts", referencedColumnName="id", unique=false)
     */
    private $carts;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="product")
     * @ORM\JoinColumn(name="product", referencedColumnName="id", unique=false)
     */
    private $products;

    /**
    * @ORM\Column(type="integer")
    */
    private $count=1;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="cartProduct")
     * @ORM\JoinColumn(name="order", referencedColumnName="id", unique=false)
     */
    private $order;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct() {
        $this->carts = new ArrayCollection();
    }

    /**
     * @param $cart
     * @return $this
     */
    public function addCart($cart)
    {
        $this->carts = $cart;
        return $this;
    }

    /**
     * Remove product
     * @param Cart $cart
     */
    public function removeCart(Cart $cart)
    {
        $this->carts->removeElement($cart);
    }

    /**
     * @return CartProduct
     */
    public function addCount()
    {
        $this->count++;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     * @return CartProduct
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param mixed $carts
     * @return CartProduct
     */
    public function setCarts($carts)
    {
        $this->carts = $carts;
        return $this;
    }

    /**
     * @param mixed $order
     * @return CartProduct
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }
}
