<?php
//
//
//namespace AppBundle\Entity;
//
//
//use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Component\HttpFoundation\File\File;
//
///**
// * @ORM\Entity
// * @ORM\Table(name="media")
// */
//class Media
//{
//    /**
//     * @ORM\Id
//     * @ORM\Column(type="integer")
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    protected $id;
//
//    /**
//     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
//     * @var File
//     */
//    private $imageFile;
//
//    /**
//     * @ORM\Column(type="datetime")
//     * @var \DateTime
//     */
//    private $updatedAt;
//
//    public function setImageFile(File $image = null)
//    {
//        $this->imageFile = $image;
//
//        if ($image) {
//            $this->updatedAt = new \DateTime('now');
//        }
//    }
//
//    public function getImageFile()
//    {
//        return $this->imageFile;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * @return \DateTime
//     */
//    public function getUpdatedAt()
//    {
//        return $this->updatedAt;
//    }
//
//    /**
//     * @param \DateTime $updatedAt
//     */
//    public function setUpdatedAt($updatedAt)
//    {
//        $this->updatedAt = $updatedAt;
//    }
//}
//
//
