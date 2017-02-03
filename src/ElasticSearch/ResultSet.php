<?php
namespace EuropeanSourcing\Api\ElasticSearch;


use EuropeanSourcing\Api\Model\Product;
use EuropeanSourcing\Api\Model\Attribute\AttributeGroup;

class ResultSet implements \ArrayAccess,\Iterator, \Countable
{
    /**
     * Tableau de produit
     * @var array
     */
    private $products;

    /**
     * Nombre de produits
     * @var integer
     */
    private $count;

    /**
     * Facettes categories
     * @var array
     */
    private $categories;

    /**
     * Facette marque
     * @var array
     */
    private $brands;

    /**
     * Facette attributes
     * @var array
     */
    private $attributeGroups;

    /**
     * Facette stock
     * Cette variable contient le nombre de produits ayant du stock
     * @var integer
     */
    private $stock;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = array();
        $this->categories = array();
        $this->brands = array();
        $this->attributeGroups = array();
        $this->stock = 0;
        $this->count = 0;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
        return $this;
    }

    public function addCategory($category)
    {
        $this->categories[$category->getIdCategory()] = $category;
    }

    /**
     * Cherche les sous-catégorie d'une catégorie donnée
     * Sinon $categoryId est null, on renvoit les cat de
     * plus haut niveau
     *
     * @param integer $categoryId
     */
    public function searchSubCategory($categoryId)
    {
        if (null === $categoryId) {
            return $this->categories;
        }
        foreach ($this->categories as $category) {
            $result = $category->search($categoryId);
            if (null !== $result) {
                return $result->getChildren();
            }
        }

        return $this->categories;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands(array $brands)
    {
        $this->brands = $brands;
        return $this;
    }

    /*public function addBrand(Brand $brand)
    {
        $this->brands[$brand->getIdBrand()] = $brand;
    }*/

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    public function getAttributeGroups()
    {
        return $this->attributeGroups;
    }

    public function setAttributeGroups(array $attributeGroups)
    {
        $this->attributeGroups = $attributeGroups;
        return $this;
    }

    public function searchAttribute($attributeId)
    {
        foreach ($this->attributeGroups as $attributeGroup) {
            if (null !== ($attribute = $attributeGroup->searchAttribute($attributeId))) {
                return $attribute;
            }
        }

        return null;
    }

    /**
     * Recherche un objet attributGroup et le retourne
     *
     * @param integer $attributeGroupId
     * @return AttributeGroup|NULL
     */
    public function getAttributeGroup($attributeGroupId)
    {
        foreach ($this->attributeGroups as $attributeGroup) {
            if ($attributeGroup->getId() == $attributeGroupId) {
                return $attributeGroup;
            }
        }

        return null;
    }

    /**
     * Ajoute ou remplace un attributeGroup
     *
     * @param AttributeGroup $newAttributeGroup
     * @return \MewPro\ElasticSearch\ResultSet
     */
    public function setAttributeGroup(AttributeGroup $newAttributeGroup)
    {
        foreach ($this->attributeGroups as $k => $attributeGroup) {
            if ($attributeGroup->getId() == $newAttributeGroup->getId()) {
                $this->attributeGroups[$k] = $newAttributeGroup;
            }
        }

        return $this;
    }

    /**
     * Ajoute un autre resultset à celui-ci
     * par exemple sur les home pour fusionner produits phares et nouveaux produits
     *
     * @param ResultSet $resultset
     */
    /*public function add(ResultSet $resultset)
    {
        $this->products     = array_merge($this->products, $resultset->getProducts());
        $this->brands       = array_merge($this->brands, $resultset->getBrands());
        $this->categories   = array_merge($this->categories, $resultset->getCategories());
        $this->stock        = $this->stock + $this->getStock();
        $this->total['products']
            = $this->totalProducts
            = $this->totalProducts + $this->getTotalProducts();
    }*/

    public function offsetExists($offset)
    {
        return isset($this->products[$offset]);
    }

    public function offsetGet($offset)
    {
        if (isset($this->products[$offset])) {
            return $this->products[$offset];
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        $this->products[$offset] = $value;
        return $this;
    }

    public function offsetUnset($offset)
    {
        unset($this->products[$offset]);
    }

    public function current()
    {
        return current($this->products);
    }

    public function key()
    {
        return key($this->products);
    }

    public function next()
    {
        return next($this->products);
    }

    public function rewind()
    {
        return reset($this->products);
    }

    public function valid()
    {
        return key($this->products) !== null;
    }

    public function count()
    {
        return $this->count;
    }
}