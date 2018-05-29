<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Cart", mappedBy="user")
     * @ORM\Column(nullable=true)
     */
    private $cart;

    /**
    * @ORM\OneToOne(targetEntity="UserMedia", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name= "media_id", referencedColumnName="id")
    */
    private $media;

    public function __construct()
    {
        parent::__construct();
        $this->cart= new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getcart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setcart($cart)
    {
        $this->cart = $cart;
    }

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
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param $media
     * @return $this
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }



//    /**
//     * @return mixed
//     */
//    public function getImage()
//    {
//        return $this->image;
//    }
}
