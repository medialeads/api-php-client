<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

class Product implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * Id du produit
     *
     * @var integer
     */
    protected $id;

    /**
     * Supplier
     * @var Supplier
     */
    protected $supplier;

    /**
     * Marque
     *
     * @var Brand
     */
    protected $brand;

    /**
     * Image par defaut
     * @var Image
     */
    protected $image;

    /**
     * Toutes les images (uniques)
     * @var array
     */
    protected $images;

    /**
     * @var integer
     */
    protected $bestVariant;

    /**
     * @var array of Variant
     */
    protected $variants;


    /**
     * Constructor
     *
     * @param array $product
     */
    public function __construct()
    {
        $this->variants = [];
    }

    /**
     * Getter Id
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter Id
     *
     * @param integer $id
     * @return \MewPro\ElasticSearch\Model\Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get Supplier
     * @return Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set Supplier
     * @param Supplier $supplier
     * @return Product
     */
    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }

    /**
     * Get Brand
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set Brand
     * @param Brand $brand
     * @return Product
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     *
     * @param array $images
     * @return Product
     */
    public function setImages(array $images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @param Image $image
     * @return Product
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
        return $this;
    }


    /**
     * Raccourci vers le nom de la meilleur déclinaison
     * @return string
     */
    public function getName()
    {
        return $this->bestVariant->getName();
    }

    /**
     * Raccourci vers la description de la meilleur déclinaison
     * @return string
     */
    public function getDescription()
    {
        return $this->bestVariant->getDescription();
    }

    /**
     * Raccourci vers la référence de la meilleur déclinaison
     * @return string
     */
    public function getReference()
    {
        return $this->bestVariant->getReference();
    }

    /**
     * Raccourci vers la référence fournisseur de la meilleur déclinaison
     * @return string
     */
    public function getReferenceSupplier()
    {
        return $this->bestVariant->getReferenceSupplier();
    }

    /**
     * Shortcut for lowest price of all variants
     */
    public function getLowestPrice()
    {
        //return $this->lowestPrice;
        $min = array();
        foreach ($this->variants as $variant) {
            if ( (null === $min) || ($min > $variant->getLowestPrice())) {
                $min = $variant->getLowestPrice();
            }
        }

        return $min;
    }

    /**
     * Getter image
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Setter Image
     *
     * @param Image $image
     * @return \MewPro\ElasticSearch\Model\Product
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     *
     * @return Variant
     */
    public function getBestVariant()
    {
        return $this->bestVariant;
    }

    /**
     * @param Variant $bestVariant
     * @return Product
     */
    public function setBestVariant(Variant $bestVariant)
    {
        $this->bestVariant = $bestVariant;
        return $this;
    }

    /**
     *
     * @return the array
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     *
     * @param array $variants
     */
    public function setVariants(array $variants)
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * Add variant
     *
     * @param Variant $variant
     * @return Product
     */
    public function addVariant(Variant $variant)
    {
        $this->variants[] = $variant;
        return $this;
    }
}