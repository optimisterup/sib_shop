<?php
namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="item", type="string")
 * @ORM\DiscriminatorMap(
 *     {"itemrecordproductmedia"="ItemRecordProductMedia","product"="Product","productmedia"="ProductMedia"}
 * )
 */
class ItemRecordProductMedia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}