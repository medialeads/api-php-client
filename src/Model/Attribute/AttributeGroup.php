<?php
namespace EuropeanSourcing\Api\Model\Attribute;

class AttributeGroup
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
     * Attributes
     *
     * @var array
     */
    protected $children;

    /**
     * Attributes "primaires"
     * Par exemple, pour kika givré ou kika foncé, on aura
     * le $primary => 'kika'
     * et les nuances du $primary => ['givré', 'foncé']
     *
     * @var array
     */
    protected $primaries;

    /**
     * Une table des emplacements de chaque attributs dans la liste des primaries/nuances/sondaries
     * pour facilement les retrouver
     * @var array
     */
    protected $stateTable;

    /**
     * Constructor
     *
     * @param array $attributeGroup
     */
    public function __construct()
    {
        $this->children = array();
        $this->primaries = null;
        $this->stateTable = null;
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
        foreach ($this->cildren as $child) {
            $child->setGroup($this);
        }
        return $this;
    }

    public function addChildren(Attribute $attribute)
    {
        $attribute->setGroup($this);
        $this->children[] = $attribute;
        return $this;
    }

    /**
     * Recherche dans la table un attribut par son id
     *
     * @param integer $attributeId
     * @return array|NULL
     */
    public function searchAttribute($attributeId)
    {
        if (null === $this->stateTable) {
            $this->getPrimaries();
        }

        if (isset($this->stateTable[$attributeId])) {
            return $this->stateTable[$attributeId];
        }

        return null;
    }

    public function getPrimaries()
    {
        if (null !== $this->primaries) {
            return $this->primaries;
        }

        foreach ($this->children as $attribute) {
            $name = ucwords(strtolower(trim($attribute->getName())));

            $this->extractNuance($attribute, $name);
        }

        // si un primary n'a pas d'id, mais a 1 et 1 seule nuance,
        // on remplate le primary par la nuance
        foreach ($this->primaries as $primary) {
            if (null === $primary->getId()) {
                if (count($primary->getNuances()) === 1) {
                    $nuance = current($primary->getNuances());
                    $primary->setId($nuance->getId());
                    $primary->setName($nuance->getName());
                    $primary->setCount($nuance->getCount());
                    $primary->setNuances(array());
                }
            }
        }

        // on rempli la table d'état qui va nous permette de rechercher facilement
        foreach ($this->primaries as $primary) {
            $primary->setGroup($this);

            $this->stateTable[$primary->getId()] = $primary;

            foreach ($primary->getNuances() as $nuance) {
                $nuance->setGroup($this);
                $nuance->setPrimary($primary);

                $this->stateTable[$nuance->getId()] = $nuance;
            }
        }

        return $this->primaries;
    }

    /**
     * Extrait et enregistre une couleur et sa nuance
     *
     * @param Attribute $attribute
     * @param string $name
     */
    private function extractNuance(Attribute $attribute, $name)
    {
        // on coupe d'abord s'il y a plusieurs attributs
        if (($pos = strpos($name, '/')) !== false) {
            $firstName = substr($name, 0, $pos);

        } else {
            $firstName = $name;
        }

        // on cherche le primaire dans le 1er attribut
        if (($pos = strpos($firstName, ' ')) !== false) {
            $primaryName = substr($name, 0, $pos);
        } else {
            $primaryName = $firstName;
        }

        if (!isset($this->primaries[$primaryName])) {
            $this->primaries[$primaryName] = new AttributePrimary();
            $this->primaries[$primaryName]->setName($primaryName);
        }

        // si c'est une nuance
        if ($primaryName !== $name) {
            $nuance = new AttributeNuance($attribute);
            $nuance->setName($name);
            $nuance->setFullName($name);
            $this->primaries[$primaryName]->addNuance($nuance);

        // c'est un primaire
        } else {
            if (!isset($this->primaries[$name])) {
                $this->primaries[$name] = new AttributePrimary();
                $this->primaries[$name]->setName($name);
            }

            $this->primaries[$name]->setId($attribute->getId());
            $this->primaries[$name]->setCount($attribute->getCount());
        }
    }
}