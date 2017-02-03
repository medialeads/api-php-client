<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;
use EuropeanSourcing\Api\Model\Attribute\Attribute;

/**
 * Model Variant
 *
 * @author wamania
 */
class Variant implements \ArrayAccess
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
     * @var string
     */
    protected $description;

    /**
     * Référence
     * @var string
     */
    protected $reference;

    /**
     * Référence fournisseur
     * @var string
     */
    protected $referenceSupplier;

    /**
     * @var integer
     */
    protected $stock;

    /**
     * @var string
     */
    protected $video;

    /**
     * @var integer
     */
    protected $minimalQuantity;

    /**
     * @var string
     */
    protected $ean;

    /**
     * @var array of Image
     */
    protected $images;

    /**
     * @var array of Price
     */
    protected $prices;

    /**
     * @var array of Marking
     */
    protected $markings;

    /**
     * @var array of Attribute
     */
    protected $attributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = [];
        $this->prices = [];
        $this->markings = [];
        $this->attributes = [];
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
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     *
     * @param array $images
     * @return Variant
     */
    public function setImages(array $images = null)
    {
        $this->images = $images;
        return $this;
    }

    /**
     *
     * @param Image $image
     * @return Variant
     */
    public function addImage(Image $image)
    {
        $image->addVariantId($this->id);
        $this->images[] = $image;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     *
     * @param integer $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     *
     * @param string $reference
     * @return Variant
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getReferenceSupplier()
    {
        return $this->referenceSupplier;
    }

    /**
     *
     * @param string $referenceSupplier
     * @return Variant
     */
    public function setReferenceSupplier($referenceSupplier)
    {
        $this->referenceSupplier = $referenceSupplier;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     *
     * @param array $prices
     * @return Variant
     */
    public function setPrices(array $prices = null)
    {
        $this->prices = $prices;
        return $this;
    }

    /**
     * @param Price $price
     * @return Variant
     */
    public function addPrice(Price $price)
    {
        $this->prices[] = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getLowestPrice()
    {
        $min = null;
        foreach ($this->prices as $price) {
            if ( (null === $min) || ($price->getPrice() < $min) ) {
                $min = $price->getPrice();
            }
            if (null !== $price->getDiscountedPrice()) {
                if ( (null === $min) || ($price->getDiscountedPrice() < $min) ) {
                    $min = $price->getDiscountedPrice();
                }
            }
        }

        return $min;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     * @return Variant
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMinimalQuantity()
    {
        return $this->minimalQuantity;
    }

    /**
     * @param integer $minimalQuantity
     * @return Variant
     */
    public function setMinimalQuantity($minimalQuantity)
    {
        $this->minimalQuantity = $minimalQuantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param string $video
     * @return Variant
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @return array
     */
    public function getMarkings()
    {
        return $this->markings;
    }

    /**
     * @param array $markings
     * @return Variant
     */
    public function setMarkings(array $markings)
    {
        $this->markings = $markings;
        return $this;
    }

    /**
     * @param Marking $marking
     * @return Variant
     */
    public function addMarking(Marking $marking)
    {
        $this->markings[] = $marking;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     *
     * @param array $attributes
     * @return Variant
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     *
     * @param Attribute $attribute
     * @return Variant
     */
    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    public function getAttributeNames()
    {
        $attributeNames = [];
        foreach ($this->attributes as $attribute) {
            $attributeNames[] = ucwords($attribute->getName());
        }

        return implode(', ', $attributeNames);
    }
}