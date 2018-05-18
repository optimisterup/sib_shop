<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="basket")
 */
class Basket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="basket")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     **/
    protected $userId;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="basket")
     */
    protected $productId;

//    /**
//     * @ORM\OneToOne(targetEntity="Order", mappedBy="basketId")
//     **/
//    protected $order;

    public function __construct()
    {
        $this->productId = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $userId
     * @return Basket
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }
    public function __toString()
    {
        return (string) $this->userId;
    }

//    /**
//     * @return mixed
//     */
//    public function getOrder()
//    {
//        return $this->order;
//    }
//
//    /**
//     * @param mixed $order
//     */
//    public function setOrder($order)
//    {
//        $this->order = $order;
//    }
}
