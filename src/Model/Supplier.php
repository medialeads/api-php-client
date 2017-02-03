<?php
namespace EuropeanSourcing\Api\Model;

use EuropeanSourcing\Api\Model\Common\ArrayAccessTrait;

class Supplier implements \ArrayAccess
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
    protected $country;

    /**
     * @var array
     */
    protected $locales;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->locales = [];
    }

    /**
     *
     * @return the integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param integer $id
     * @return Supplier
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return the string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return Supplier
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return the ArrayCollection
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     *
     * @param ArrayCollection $locales
     * @return Supplier
     */
    public function setLocales(array $locales)
    {
        $this->locales = $locales;
        return $this;
    }

    /**
     *
     * @param Locale $locale
     * @return Supplier
     */
    public function addLocale(Locale $locale)
    {
        if (!$this->locales->contains($locale)) {
            $this->locales->add($locale);
        }
        return $this;
    }

    /**
     *
     * @param Locale $locale
     * @return Supplier
     */
    public function removeLocale(Locale $locale)
    {
        $this->locales->removeElement($locale);
        return $this;
    }

    /**
     * Get Country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set Country
     *
     * @param string $country
     * @return Supplier
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
}