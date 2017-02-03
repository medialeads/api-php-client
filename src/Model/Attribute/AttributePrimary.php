<?php
namespace EuropeanSourcing\Api\Model\Attribute;

class AttributePrimary implements AttributeInterface
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
     * Différentes nuances de cette couleur
     *
     * @var unknown
     */
    protected $nuances;

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

    public function getFullName()
    {
        return $this->name;
    }

    public function getCount()
    {
        /*$count = $this->count;

        foreach ($this->nuances as $nuance) {
            $count += $nuance->getCount();
        }
        return $count;*/

        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    public function getNuances()
    {
        return $this->nuances;
    }

    public function setNuances($nuances)
    {
        $this->nuances = $nuances;
        return $this;
    }

    public function addNuance(AttributeNuance $nuance)
    {
        $this->nuances[] = $nuance;
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

    /**
     * Id de l'attribut et de toutes ses nuances
     */
    /*public function getIds()
    {
        $ids = array();
        foreach ($this->nuances as $nuance) {
            $ids[] = $nuance->getId();
        }
        return $ids;
    }*/


}