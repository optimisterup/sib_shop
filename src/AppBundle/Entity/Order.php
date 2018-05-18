<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="order")
     * @ORM\JoinColumn(name="us erId", referencedColumnName="id")
     **/
    protected $userId;

//    /**
//     * @ORM\OneToOne(targetEntity="Basket", inversedBy="order")
//     * @ORM\JoinColumn(name="basketId", referencedColumnName="id")
//     **/
//    protected $basketId;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @return mixed
//     */
//    public function getBasketId()
//    {
//        return $this->basketId;
//    }
//
//    /**
//     * @param mixed $basketId
//     */
//    public function setBasketId($basketId)
//    {
//        $this->basketId = $basketId;
//    }

    /**
     * @param mixed $userId
     * @return Order
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

    public function __toString()
    {
        return "name of order";
    }
}
