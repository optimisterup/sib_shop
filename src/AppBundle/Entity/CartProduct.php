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
    private $cart;

//    /**
//     * @ORM\ManyToOne(targetEntity="Product", inversedBy="cartProduct")
//     * @ORM\JoinColumn(name="product", referencedColumnName="id")
//     */
//    private $product;

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

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     * @return CartProduct
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

//    /**
//     * @param mixed $product
//     * @return CartProduct
//     */
//    public function setProduct($product)
//    {
//        if ($product){
//            $this->count++;
//        }
//        $this->product = $product;
//        return $this;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getProduct()
//    {
//        return $this->product;
//    }



    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="cart_product",
     *      joinColumns={@ORM\JoinColumn(name="name", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product", referencedColumnName="id", unique=false)}
     *      )
     */
    private $product;

    public function __construct() {
        $this->product = new ArrayCollection();
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
            $this->product[] = $product;
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
        $this->product->removeElement($product);
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
     * @param mixed $count
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

//    public function __construct()
//    {
//        $this->cart = new ArrayCollection();
//        $this->product = new ArrayCollection();
//    }



}
