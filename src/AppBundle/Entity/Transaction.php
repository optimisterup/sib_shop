<?php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="transaction")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="transaction")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", unique=false, nullable=true)
     */
    private $order;

    /**
     * @ORM\Column(type="text")
     */
    private $paypal_id;

    /**
     * @ORM\Column(type="text")
     */
    private $status;

    /**
     * @param Orders $order
     * @return $this
     */
    public function setOrder(Orders $order)
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
    /**
     * @ORM\Column(type="string")
     */
    private $detail;
    /**
     * @param mixed $detail
     * @return Transaction
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param mixed $paypal_id
     * @return Transaction
     */
    public function setPaypalId($paypal_id)
    {
        $this->paypal_id = $paypal_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaypalId()
    {
        return $this->paypal_id;
    }

    /**
     * @param mixed $status
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}