<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @Vich\Uploadable
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

    /**
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="products")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity="ProductMedia", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="media_user",
     *      joinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $media;

    public function __construct() {
        $this->media  = new ArrayCollection();
        $this->products  = new ArrayCollection();
    }

    /**
     * @param ProductMedia $product
     * @return $this
     */
    public function addMedia(ProductMedia $product)
    {
        $product->setProduct($this);
        $this->media[] = $product;
        return $this;
    }

    public function removeMedia(ProductMedia $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * @return Collection
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    /**
     * @param CartProduct $cartproduct
     * @return $this
     */
    public function addProduct(CartProduct $cartproduct)
    {
        $cartproduct->setProducts($this);
        $this->products[] = $cartproduct;
        return $this;
    }

    /**
     * @param CartProduct $cartproduct
     */
    public function removeProduct(CartProduct $cartproduct)
    {
        $this->products->removeElement($cartproduct);
    }

    /**
     * @return Collection
     */
    public function getProduct(): Collection
    {
        return $this->products;
    }

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



}
