<?php
namespace EuropeanSourcing\Api\Model;

class Brand
{
    /**
     * Id de la marque
     *
     * @var integer
     */
    protected $id;

    /**
     * Nom de la marque
     *
     * @var string
     */
    protected $name;

    /**
     * Nombre de produits dans la marque
     *
     * @var integer
     */
    protected $count;

    /**
     * Constructor
     *
     * @param array $brand
     * @return boolean
     */
    public function __construct()
    {

    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param integer $id
     * @return Brand
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     *
     * @param integer $count
     * @return Brand
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

}