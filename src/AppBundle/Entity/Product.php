<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", length=12)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="product")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     **/
    private $category;

/////////////////
    /**
     * @ORM\ManyToOne(targetEntity="Basket", inversedBy="productId")
     * @ORM\JoinColumn(name="basket", referencedColumnName="id")
     **/
    private $basket;
////////////////
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString()
    {
        return $this->name ?: "";
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param mixed $basket
     */
    public function setBasket($basket)
    {
        $this->basket = $basket;
    }

    /**
     * @return mixed
     */
    public function getBasket()
    {
        return $this->basket;
    }

}
