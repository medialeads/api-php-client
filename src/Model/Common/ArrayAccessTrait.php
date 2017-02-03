<?php
namespace EuropeanSourcing\Api\Model\Common;

trait ArrayAccessTrait
{
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }

    public function offsetGet($offset)
    {
        if (isset($this->{$offset})) {
            return $this->{$offset};
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        if (isset($this->{$offset})) {
            $this->{$offset} = $value;
        }
        return $this;
    }

    public function offsetUnset($offset)
    {
        if (isset($this->{$offset})) {
            $this->{$offset} = null;
        }
        return $this;
    }
}