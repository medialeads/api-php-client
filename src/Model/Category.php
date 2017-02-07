<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

class Category implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * Id
     * @var integer
     */
    protected $id;

    /**
     * Le nom
     * @var string
     */
    protected $name;

    /**
     * Fil d'ariane
     * @var string
     */
    protected $breadcrumb;

    /**
     * Category parente
     * @var Category
     */
    protected $parent;

    /**
     * Nombre de produits dans la category
     * @var integer
     */
    protected $count;

    /**
     * Sous-categories
     * @var array
     */
    protected $children;

    /**
     * Constructor
     *
     * @param array $category
     * @return boolean
     */
    public function __construct()
    {
        $this->parent = null;
        $this->children = array();
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParentId()
    {
        if (null === $this->parent) {
            return null;
        }
        return $this->parent->getId();
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children = null)
    {
        $this->children = $children;
        return $this;
    }

    public function addChildren($child)
    {
        $this->children[] = $child;
        return $this;
    }

    public function search($categoryId)
    {
        if ($this->id == $categoryId) {
            return $this;
        }
        foreach ($this->children as $child) {
            if (null !== ($subchild = $child->search($categoryId))) {
                return $subchild;
            }
        }

        return null;
    }
}