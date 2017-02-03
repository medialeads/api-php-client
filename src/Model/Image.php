<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

class Image implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * Id
     * @var integer
     */
    protected $id;

    /**
     * Vrai nom du fichier
     *
     * @var string
     */
    protected $name;

    /**
     * Position de l'image
     *
     * @var integer
     */
    protected $position;

    /**
     * Constructor
     *
     * @param array $image
     */
    public function __construct()
    {

    }

    /**
     *
     * @param integer $id
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return integer
     */
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

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}