<?php
namespace AppBundle\Entity;

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

    private $image;

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
     * @ORM\ManyToMany(targetEntity="Cart", mappedBy="products")
     **/
    private $basket;

//    /**
//     * @ORM\OneToOne(targetEntity="ProductMedia", cascade={"persist", "remove"})
//     * @ORM\JoinColumn(name= "media_id", referencedColumnName="id")
//     */

//    /**
//     * Many Users have Many Groups.
//     * @var ArrayCollection
//     * @ORM\ManyToMany(targetEntity="ProductMedia")
//     */

    /**
     * @ORM\ManyToMany(targetEntity="ProductMedia")
     * @ORM\JoinTable(name="product_media",
     *      joinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")}
     *      )
     */
    private $media;

    public function __construct() {
        $this->basket = new ArrayCollection();
//        dump($this->media);die;

        $this->media = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @return mixed
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @return $this
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}
