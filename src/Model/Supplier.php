<?php
namespace EuropeanSourcing\Api\Model;

class Supplier
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Locale
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
     *
     * @return Locale
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @param Locale $country
     */
    public function setCountry(Locale $country)
    {
        $this->country = $country;
        return $this;
    }
}