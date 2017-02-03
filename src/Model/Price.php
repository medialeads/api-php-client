<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

/**
 * Price
 *
 * @author wamania
 */
class Price implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * @var integer
     */
    protected $quantity;

    /**
     * @var float
     */
    protected $discountedPrice;

    /**
     * @var float
     */
    protected $price;

    /**
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     *
     * @param integer $quantity
     * @return Price
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     *
     * @param float $discountedPrice
     * @return Price
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     *
     * @param float $price
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

}