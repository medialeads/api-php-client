<?php
namespace EuropeanSourcing\Api\ElasticSearch;

class SearchRequest
{
    /**
     * Text search
     *
     * @var string
     */
    protected $query;

    /**
     * Add aggregations (facets) : Categories, brands, attributes
     * Use it to add filters for your current search
     *
     * @var boolean
     */
    protected $withAggs;

    /**
     * Language (fr|en|de|it|es|nl|pt)
     * @var string
     */
    protected $language;

    /**
     * Filter by min price
     * @var float
     */
    protected $minPrice;

    /**
     * Filter by max price
     * @var float
     */
    protected $maxPrice;

    /**
     * Search by category ids
     *
     * @var array
     */
    protected $categoryIds;

    /**
     * Search by one category
     *
     * @var integer
     */
    protected $categoryId;

    /**
     * Search by supplier ids
     *
     * @var array
     */
    protected $supplierIds;

    /**
     * Search by one brand id
     *
     * @var integer
     */
    protected $brandId;

    /**
     * Search by attributes ids
     *
     * @var array of integer
     */
    protected $attributeIds;

    /**
     * Operator for attributes (or|and)
     *
     * @var string
     */
    protected $attributeOperator;

    /**
     * Only new products (< 3 month)
     *
     * @var boolean
     */
    protected $isNew;

    /**
     * Only products with stock
     *
     * @var boolean
     */
    protected $hasStock;

    /**
     * Don't want this ids
     *
     * @var array
     */
    protected $notIds;

    /**
     * Only in this ids
     *
     * @var array of integer
     */
    protected $ids;

    /**
     * Only this variant ids
     *
     * @var array of integer
     */
    protected $variantIds;

    /**
     * For categories aggregation (facet)
     * (plain|tree)
     *
     * @var string
     */
    protected $cSchema;

    /**
     * For attributes aggregation (facet)
     * (plain|tree)
     *
     * @var string
     */
    protected $aSchema;

    /**
     * Sort
     * (random|price|update|score)
     *
     * @var string
     */
    protected $sort;

    /**
     * Sens
     * (asc|desc)
     *
     * @var string
     */
    protected $sens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->query        = null;
        $this->supplierIds = null;
        $this->brandId      = null;
        $this->categoryIds  = null;
        $this->categoryId   = null;
        $this->attributeIds = null;
        $this->hasStock     = null;
        $this->isNew        = null;
        $this->minPrice     = null;
        $this->maxPrice     = null;
        $this->notIds       = null;
        $this->ids          = null;
        $this->withAggs     = true;
        $this->cSchema       = 'tree';
        $this->aSchema       = 'tree';
        $this->attributeOperator = 'and';
        $this->sort = 'score';
        $this->sens = 'desc';
    }

    /**
     * Pas les même noms entre elastic et myeasyweb, ici c'est elastic
     */
    public function getElasticparameters()
    {
        $parameters = array(
            'q' => $this->getQuery(),
            'b' => $this->getBrandId(),
            's' => $this->getSupplierIds(),
            'prix_min' => $this->getMinPrice(),
            'prix_max' => $this->getMaxPrice(),
            'withstockonly' => $this->getHasStock(),
            'not_ids' => $this->getNotIds(),
            'ids' => $this->getIds(),
            'variantIds' => $this->getVariantIds(),
            'withaggs' => (int)$this->getWithAggs(),
            'language' => $this->getLanguage(),
            'aschema' => $this->getASchema(),
            'cschema' => $this->getCSchema(),
            'sort' => $this->getSort(),
            'sens' => $this->getSens(),
        );

        if (!empty($this->categoryId)) {
            $parameters['c'] = array($this->categoryId);
        } else {
            $parameters['c'] = null;
        }

        if (!empty($this->attributeIds)) {
            $parameters['a'] = array();

            foreach ($this->attributeIds as $attributeGroup) {
                $parameters['a'] = array_merge($parameters['a'], $attributeGroup);
            }

            $parameters['aop'] = $this->attributeOperator;
        }

        return $parameters;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        if (!empty($query)) {
            $this->query = $query;
        }
        return $this;
    }

    public function getMinPrice()
    {
        return $this->minPrice;
    }

    public function setMinPrice($minPrice)
    {
        if (!empty($minPrice)) {
            $this->minPrice = $minPrice;
        }
        return $this;
    }

    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    public function setMaxPrice($maxPrice)
    {
        if (!empty($maxPrice)) {
            $this->maxPrice = $maxPrice;
        }
        return $this;
    }

    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    public function setCategoryIds(array $categoryIds = null)
    {
        $this->categoryIds = $categoryIds;
        return $this;
    }

    public function getSupplierIds()
    {
        return $this->supplierIds;
    }

    public function setSupplierIds(array $supplierIds = null)
    {
        $this->supplierIds = $supplierIds;
        return $this;
    }

    public function addSupplierId($supplierId)
    {
        $this->supplierIds[] = $supplierId;
        return $this;
    }

    public function getBrandId()
    {
        return $this->brandId;
    }

    public function setBrandId($brandId)
    {
        $this->brandId = $brandId;
        return $this;
    }

    public function getAttributeIds()
    {
        return $this->attributeIds;
    }

    public function setAttributeIds(array $attributeIds = null)
    {
        $this->attributeIds = $attributeIds;
        return $this;
    }

    /**
     * Retire un ou plusieurs attributes de la liste des paramètres
     * en fonction d'un attributeGroupId
     *
     * @param integer $attributeGroupId
     * @return \MewPro\ElasticSearch\SearchRequest
     */
    public function removeAttribute($attributeGroupId)
    {
        if (isset($this->attributeIds[$attributeGroupId])) {
            unset($this->attributeIds[$attributeGroupId]);
        }

        return $this;
    }

    public function getIsNew()
    {
        return $this->isNew;
    }

    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
        return $this;
    }

    public function getHasStock()
    {
        return $this->hasStock;
    }

    public function setHasStock($hasStock)
    {
        if (!empty($hasStock)) {
            $this->hasStock = $hasStock;
        }
        return $this;
    }

    public function getNotIds()
    {
        return $this->notIds;
    }

    public function setNotIds(array $notIds = null)
    {
        $this->notIds = $notIds;
        return $this;
    }

    public function addNotIds(array $notIds = null)
    {
        $this->notIds = array_merge($this->notIds, $notIds);
        return $this;
    }

    public function getIds()
    {
        return $this->ids;
    }

    public function setIds($ids)
    {
        $this->ids = $ids;
        return $this;
    }

    public function getWithAggs()
    {
        return $this->withAggs;
    }

    public function setWithAggs($withAggs)
    {
        $this->withAggs = $withAggs;
        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    public function getCSchema()
    {
        return $this->cSchema;
    }

    public function setCSchema($cSchema)
    {
        $this->cSchema = $cSchema;
        return $this;
    }

    public function getASchema()
    {
        return $this->aSchema;
    }

    public function setASchema($aSchema)
    {
        $this->aSchema = $aSchema;
        return $this;
    }

    public function getAttributeOperator()
    {
        return $this->attributeOperator;
    }

    public function setAttributeOperator($attributeOperator)
    {
        $this->attributeOperator = $attributeOperator;
        return $this;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    public function getSens()
    {
        return $this->sens;
    }

    public function setSens($sens)
    {
        $this->sens = $sens;
        return $this;
    }

    /**
     * @return array
     */
    public function getVariantIds()
    {
        return $this->variantIds;
    }

    /**
     * @param array $variantIds
     * @return SearchRequest
     */
    public function setVariantIds(array $variantIds)
    {
        $this->variantIds = $variantIds;
        return $this;
    }

}