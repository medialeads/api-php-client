<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

class Marking implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

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
     * @return Marking
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
     * @return Marking
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}