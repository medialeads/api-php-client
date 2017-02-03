<?php
namespace EuropeanSourcing\Api\ElasticSearch;

class SearchRequest implements \Iterator
{
    /**
     * Recherche texte
     * @var string
     */
    protected $query;

    /**
     * Recherche simple ou recherche avec cycle fournisseur
     * @var boolean
     */
    protected $isSimple;

    /**
     * Renvoi les aggregations avec la recherche (ou pas)
     * @var boolean
     */
    protected $withAggs;

    /**
     * L'id du pays acceptant le sourcing (supplier.sourcings.idLocation)
     * @var integer
     */
    protected $locationId;

    /**
     * La langue dans laquelle rechercher
     * @var integer
     */
    protected $locale;

    /**
     * L'id du pays d'origine du supplier (supplier.idLocation)
     * @var integer
     */
    protected $countryId;

    /**
     * Recherche par prix min
     * @var float
     */
    protected $minPrice;

    /**
     * Recherche par prix max
     * @var float
     */
    protected $maxPrice;

    /**
     * Recherche par catégorie
     * @var array
     */
    protected $categoryIds;

    /**
     * Une catégorie seulement
     * @var integer
     */
    protected $categoryId;

    /**
     * Rechercher plusieurs fournisseurs
     * @var array
     */
    protected $supplierIds;

    /**
     * Recherche par marque
     * @var integer
     */
    protected $brandId;

    /**
     * Les Ids des attributs à rechercher
     * @var array of integer
     */
    protected $attributeIds;

    /**
     * Les ids des attributs primaires
     * @var array
     */
    protected $primaryIds;

    /**
     * Les ids des attributs nuances
     * @var array
     */
    protected $nuancesIds;

    /**
     * L'opérateur pour les attributs (and/or)
     * @var string
     */
    protected $attributeOperator;

    /**
     * Nouveautés ?
     * @var boolean
     */
    protected $isNew;

    /**
     * Que les produits avec du stock
     * @var boolean
     */
    protected $hasStock;

    /**
     * Exclusion d'Ids
     * @var array
     */
    protected $notIds;

    /**
     * Inclusion d'Ids
     * @var array of integer
     */
    protected $ids;

    /**
     * Inclusion d'id de déclinaisons
     * @var array of integer
     */
    protected $variantIds;

    /**
     * Pour l'iterator
     * @var array
     */
    protected $parameters;

    /**
     * Schema pour les catégories, plain ou tree
     * @var string
     */
    protected $cSchema;

    /**
     * Schema pour les attributes, plain ou tree
     * @var string
     */
    protected $aSchema;

    /**
     * Sort
     * @var string
     */
    protected $sort;

    /**
     * Sens
     * @var string
     */
    protected $sens;

    /**
     * Reseller
     * @var integer
     */
    protected $resellerId;

    /**
     * Le contenu du tableau initial, contenant tous les paramètres
     * @var array
     */
    protected $request;

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
        $this->locationId   = null;
        $this->countryId    = null;
        $this->attributeIds = null;
        $this->hasStock     = null;
        $this->isNew        = null;
        $this->minPrice     = null;
        $this->maxPrice     = null;
        $this->notIds       = null;
        $this->ids          = null;
        $this->isSimple     = true;
        $this->withAggs     = true;
        $this->cSchema       = 'tree';
        $this->aSchema       = 'tree';
        $this->attributeOperator = 'and';
        $this->sort = 'score';
        $this->sens = 'desc';
    }

    /**
     * Hydratation 4
     *
     * @param array $array
     */
    public function handleArray(array $array)
    {
        $this->setQuery($this->handleField($array, 'query'));
        $this->setCategoryId($this->handleField($array, 'category_id'));
        $this->setBrandId($this->handleField($array, 'brand'));
        $this->setAttributeIds($this->handleField($array, 'a'));
        $this->setPrimaryIds($this->handleField($array, 'p'));
        $this->setNuancesIds($this->handleField($array, 'n'));
        $this->setSort($this->handleField($array, 'sort'));
        $this->setSens($this->handleField($array, 'sens'));

        if (!empty($array['simple'])) {
            $this->setIsSimple(true);
        }

        if (!empty($array['productId'])) {
            $this->setIds(array($array['productId']));
        }
        if (!empty($array['variantId'])) {
            $this->setVariantIds(array($array['variantId']));
        }
    }

    /**
     * Retourne un champ d'un tableau, ou $default
     *
     * @param array $array
     * @param string $field
     * @param mixed $default
     * @return mixed
     */
    public function handleField($array, $field, $default = null)
    {
        if (isset($array[$field])) {
            return $array[$field];
        }
        return $default;
    }

    /**
     * Pas les même noms entre elastic et myeasyweb, ici c'est elastic
     */
    public function getElasticparameters()
    {
        $this->parameters = array(
            'q' => $this->getQuery(),
            'b' => $this->getBrandId(),
            's' => $this->getSupplierIds(),
            'prix_min' => $this->getMinPrice(),
            'prix_max' => $this->getMaxPrice(),
            'withstockonly' => $this->getHasStock(),
            'not_ids' => $this->getNotIds(),
            'ids' => $this->getIds(),
            'variantIds' => $this->getVariantIds(),
            'simple' => (int)$this->isSimple,
            'withaggs' => (int)$this->withAggs,
            'language' => $this->getLocale(),
            'aschema' => $this->getASchema(),
            'cschema' => $this->getCSchema(),
            'sort' => $this->getSort(),
            'sens' => $this->getSens(),
            'userId' => $this->getResellerId(),
        );

        if (!empty($this->categoryId)) {
            $this->parameters['c'] = array($this->categoryId);
        } else {
            $this->parameters['c'] = null;
        }

        if (!empty($this->attributeIds)) {
            $this->parameters['a'] = array();

            foreach ($this->attributeIds as $attributeGroup) {
                $this->parameters['a'] = array_merge($this->parameters['a'], $attributeGroup);
            }

            $this->parameters['aop'] = $this->attributeOperator;
        }

        /*if (null !== $this->subSearchs) {
            $this->parameters['subsearchs'] = [];
            foreach ($this->subSearchs as $subSearch) {
                $this->parameters['subsearchs'][] = $subSearch->getElasticparameters();
            }
        }*/

        return $this->parameters;
    }

    /**
     * Pour les listes complètes de categories, brands, etc sans filtres
     */
    /*public function getMinimumParameters()
    {
        $parameters = array();

        if (null !== $this->subSearchs) {
            $parameters['subsearchs'] = [];
            foreach ($this->subSearchs as $subSearch) {
                $parameters['subsearchs'][] = $subSearch->getElasticparameters();
            }
        }

        return $parameters;
    }*/

    /*public function getElasticParametersWithNoFacets()
    {
        $this->parameters = array(
            'q' => $this->getQuery(),
            's' => $this->getSupplierIds(),
            'not_ids' => $this->getNotIds(),
            'ids' => $this->getIds(),
            'simple' => (int)$this->isSimple,
            'withaggs' => (int)$this->withAggs,
            'language' => $this->getLocale(),
            'aschema' => $this->getASchema(),
            'cschema' => $this->getCSchema(),
        );
    }*/

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

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
        return $this;
    }

    public function getCountryId()
    {
        return $this->countryId;
    }

    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
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

    public function getIsSimple()
    {
        return $this->isSimple;
    }

    public function setIsSimple($isSimple)
    {
        $this->isSimple = $isSimple;
        return $this;
    }

    public function current()
    {
        if (empty($this->parameters)) {
            $this->getAllparameters();
        }

        return current($this->parameters);
    }

    public function key()
    {
        if (empty($this->parameters)) {
            $this->getAllparameters();
        }

        return key($this->parameters);
    }

    public function next()
    {
        if (empty($this->parameters)) {
            $this->getAllparameters();
        }

        return next($this->parameters);
    }

    public function rewind()
    {
        if (empty($this->parameters)) {
            $this->getAllparameters();
        }

        return reset($this->parameters);
    }

    public function valid()
    {
        if (empty($this->parameters)) {
            $this->getAllparameters();
        }

        return key($this->parameters) !== null;
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

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
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

    public function getPrimaryIds()
    {
        return $this->primaryIds;
    }

    public function setPrimaryIds(array $primaryIds = null)
    {
        $this->primaryIds = $primaryIds;
        return $this;
    }

    public function getNuancesIds()
    {
        return $this->nuancesIds;
    }

    public function setNuancesIds($nuancesIds)
    {
        $this->nuancesIds = $nuancesIds;
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

    public function getResellerId()
    {
        return $this->resellerId;
    }

    public function setResellerId($resellerId)
    {
        $this->resellerId = $resellerId;
        return $this;
    }

    /**
     * @return  array
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request)
    {
        $this->request = $request;
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