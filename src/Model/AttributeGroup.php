<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

class AttributeGroup implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * Id
     *
     * @var integer
     */
    protected $id;

    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Attributes
     *
     * @var array
     */
    protected $children;

    /**
     * Constructor
     *
     * @param array $attributeGroup
     */
    public function __construct()
    {
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

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
        foreach ($this->children as $child) {
            $child->setAttributeGroup($this);
        }
        return $this;
    }

    public function addChildren(Attribute $attribute)
    {
        $attribute->setAttributeGroup($this);
        $this->children[] = $attribute;
        return $this;
    }
}