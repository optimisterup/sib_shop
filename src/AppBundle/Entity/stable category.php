<?php
//
//namespace AppBundle\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
//
///**
// * @ORM\Entity
// * @ORM\Table(name="category")
// */
//class Category
//{
//    /**
//     * @ORM\Id
//     * @ORM\Column(type="integer")
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string")
//     */
//    private $name;
//
//    /**
//     * @ORM\Column(type="string", nullable=true)
//     */
//    private $description;
//
//    /**
//     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
//     **/
//    private $children;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
//     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
//     **/
//    private $parent;
//
//    public function __construct()
//    {
//        $this->children = new ArrayCollection();
//    }
//
//    /**
//     * @param mixed $id
//     * @return Category
//     */
//    public function setId($id)
//    {
//        $this->id = $id;
//        return $this;
//    }
//
//    /**
//     * @param mixed $name
//     * @return Category
//     */
//    public function setName($name)
//    {
//        $this->name = $name;
//        return $this;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getName()
//    {
//        return $this->name;
//    }
//
//    /**
//     * @param mixed $description
//     * @return Category
//     */
//    public function setDescription($description)
//    {
//        $this->description = $description;
//        return $this;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getDescription()
//    {
//        return $this->description;
//    }
//
//
//    /**
//     * Get id
//     *
//     * @return integer
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Add child
//     *
//     * @return Category
//     */
//    public function addChild( $child)
//    {
//        $this->children[] = $child;
//
//        return $this;
//    }
//
//    /**
//     * Remove child
//     *
//     */
//    public function removeChild($child)
//    {
//        $this->children->removeElement($child);
//    }
//
//    /**
//     * Get children
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getChildren()
//    {
//        return $this->children;
//    }
//
//    /**
//     * @param mixed $parent
//     */
//    public function setParent($parent)
//    {
//        $this->parent = $parent;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getParent()
//    {
//        return $this->parent;
//    }
//
//
//}
