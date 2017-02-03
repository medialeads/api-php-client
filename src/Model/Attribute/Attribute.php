<?php
namespace EuropeanSourcing\Api\Model\Attribute;

class Attribute implements AttributeInterface
{
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
     * Nombre de produits
     *
     * @var integer
     */
    protected $count;

    /**
     * Le parent
     *
     * @var AttributeGroup
     */
    protected $group;

    /**
     * Constructor
     *
     * @param array $attributeGroup
     */
    public function __construct()
    {

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

    public function getFullName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
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

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(AttributeGroup $group)
    {
        $this->group = $group;
        return $this;
    }



}