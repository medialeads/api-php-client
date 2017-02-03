<?php
namespace EuropeanSourcing\Api\Model;

class Image
{
    /**
     * Id
     * @var integer
     */
    protected $id;

    /**
     * Vrai nom du fichier
     *
     * @var string
     */
    protected $path;

    /**
     * Position de l'image
     *
     * @var integer
     */
    protected $position;

    /**
     * Tableau des ids des variants ayant cette image
     * @var array
     */
    protected $variantIds;

    /**
     * Constructor
     *
     * @param array $image
     */
    public function __construct()
    {

    }

    /**
     *
     * @param integer $id
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    public function getVariantIds()
    {
        return $this->variantIds;
    }

    public function setVariantIds(array $variantIds)
    {
        $this->variantIds = $variantIds;
        return $this;
    }

    /**
     * Ajoute une variante
     *
     * @param integer $variantId
     * @return \MewPro\ElasticSearch\Model\Image
     */
    public function addVariantId($variantId)
    {
        $this->variantIds[] = $variantId;
        $this->variantIds = array_unique($this->variantIds);
        return $this;
    }
}