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
     * Set id
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get full path
     * @return string
     */
    public function getPath()
    {
        return 'http://europeansourcing.com/products/'.$this->id.'-400x400.jpg';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get position
     *
     * @return number
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Image
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}