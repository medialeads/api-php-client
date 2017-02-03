<?php
namespace EuropeanSourcing\Api\Model;

class Locale
{
    /**
     * @var string
     */
    private $code;

    /**
     *
     * @return the string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
}