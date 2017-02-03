<?php
namespace EuropeanSourcing\Api\Model\Attribute;

class AttributeNuance implements AttributeInterface
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
     * Le nom entier : primary + nuance
     *
     * @var string
     */
    protected $fullName;

    /**
     * Nombre de produits
     *
     * @var integer
     */
    protected $count;

    /**
     * La couleur d'origine de cette nuance (bleu ciel => bleu)
     *
     * @var unknown
     */
    protected $primary;

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
    public function __construct($attribute = null)
    {
        if ( (null !== $attribute) && ($attribute instanceof Attribute) ) {
            $this->id = $attribute->getId();
            $this->name = $attribute->getName();
            $this->count = $attribute->getCount();
        }

        $this->nuances = array();
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

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getPrimary()
    {
        return $this->primary;
    }

    public function setPrimary($primary)
    {
        $this->primary = $primary;
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