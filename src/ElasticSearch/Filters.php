<?php

namespace EuropeanSourcing\Api\ElasticSearch;

use EuropeanSourcing\Api\Model\Brand;
use EuropeanSourcing\Api\Model\Category;

class Filters
{
    /**
     * La recherche libre
     * @var string
     */
    protected $query;

    /**
     * Liste des attributs
     *
     * @var array
     */
    protected $attributes;

    /**
     * La catégorie en cours
     * @var Category
     */
    protected $category;

    /**
     * La marque en cours
     * @var Brand
     */
    protected $brand;

    /**
     * Constructor
     *
     * @param Request $request
     */
    public function __construct()
    {
        $this->attributes = array();
    }

    /**
     * Princpalement fonction, analyse les aggregations en résultats
     * pour récupérer les objets correspondants aux ids de notre recherche
     *
     * @param ResultSet $resultSet
     */
    public function analyse(ResultSet $resultSet)
    {
        // QUERY
        if (null !== $this->request->query->get('query')) {
            $this->query = $this->request->query->get('query');
        }

        // ATTRIBUTES
        if (null !== $this->request->query->get('a')) {
            $attributeGroups = $this->request->query->get('a');

            foreach ($attributeGroups as $attributeGroup) {
                foreach ($attributeGroup as $attributeId) {
                    $attribute = $resultSet->searchAttribute($attributeId);

                    if (null !== $attribute) {
                        $this->attributes[] = $attribute;
                    }
                }
            }
        }

        // CATEGORY
        if (null !== $this->request->attributes->get('category_id')) {
            foreach ($resultSet->getCategories() as $category) {
                $result = $category->search($this->request->attributes->get('category_id'));

                if (null !== $result) {
                    $this->category = $result;
                }
            }
        }

        // BRAND
        if (null !== $this->request->query->get('brand')) {
            foreach ($resultSet->getBrands() as $brand) {
                if ($brand->getId() == $this->request->query->get('brand')) {
                    $this->brand = $brand;
                }
            }
        }
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function searchAttributeByGroup($attributeGroupId)
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getGroup()->getId() == $attributeGroupId) {
                return $attribute;
            }
        }

        return null;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
        return $this;
    }
}
