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

//    /**
//     * @ORM\OneToOne(targetEntity="User", inversedBy="cart")
//     * @ORM\JoinColumn(name="user", referencedColumnName="id")
//     **/
//    private $user;



//    /**
//     * @ORM\ManyToMany(targetEntity="Product")
//     * @ORM\JoinTable(name="cart_product",
//     *      joinColumns={@ORM\JoinColumn(name="name", referencedColumnName="id")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="product", referencedColumnName="id", unique=false)}
//     *      )
//     */
//    private $product;
//
//    public function __construct() {
//        $this->product = new ArrayCollection();
//    }
//
//    /**
//     * @param Product $product
//     * @return $this
//     */
//    public function addProduct(Product $product)
//    {
//        if ($product) {
//            // if 'updatedAt' is not defined in your entity, use another property
//            $this->updatedAt = new \DateTime('now');
//        }
//        $this->product[] = $product;
//        return $this;
//    }
//
//    /**
//     * Remove product
//     * @param Product $product
//     */
//    public function removeProduct(Product $product)
//    {
//        $this->product->removeElement($product);
//    }

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="cart")
     */
    private $cartProduct;

    public function __construct() {
        $this->cartProduct = new ArrayCollection();
    }

//    /**
//     * @return mixed
//     */
//    public function getProducts()
//    {
//        return $this->product;
//    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return (string) $this->user;
    }

    /**
     * @param mixed $cartProduct
     * @return Cart
     */
    public function setCartProduct($cartProduct)
    {
        $this->cartProduct = $cartProduct;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCartProduct()
    {
        return $this->cartProduct;
    }

}
