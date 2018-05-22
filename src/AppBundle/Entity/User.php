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

}
