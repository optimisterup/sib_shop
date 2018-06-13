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
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="cartProduct")
     * @ORM\JoinColumn(name="cart", referencedColumnName="id")
     */
    private $carts;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="cartProduct")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="cartProduct")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     **/
    private $user;

    /**
    * @ORM\Column(type="integer")
    */
    private $count=0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct() {
        $this->products = new ArrayCollection();
        $this->carts    = new ArrayCollection();
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product)
    {
        if ($product) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');

        }
            $this->products[] = $product;
        return $this;
    }

    /**
     * Remove product
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        if ($product){
            $this->count--;
        }
        $this->products->removeElement($product);
    }


    /**
     * @param Cart $cart
     * @return $this
     */
    public function addCart(Cart $cart)
    {
        if ($cart) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');

        }
        $this->carts[] = $cart;
        return $this;
    }

    /**
     * Remove product
     * @param Cart $cart
     */
    public function removeCart(Cart $cart)
    {
        if ($cart){
            $this->count--;
        }
        $this->products->removeElement($cart);
    }



    /**
     * @param mixed $user
     * @return CartProduct
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


}