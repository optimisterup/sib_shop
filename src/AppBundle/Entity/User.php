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
     * @ORM\OneToOne(targetEntity="Basket", mappedBy="userId")
     */
    private $basket;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="userId")
     **/
    private $order;

    public function __construct()
    {
        parent::__construct();
        $this->order= new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @param mixed $basket
     */
    public function setBasket($basket)
    {
        $this->basket = $basket;
    }

    /**
     * @param mixed $order
     * @return User
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
