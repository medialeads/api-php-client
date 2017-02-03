<?php
namespace EuropeanSourcing\Api\Model;

/**
 * Category Locale
 *
 * @author wamania
 */
class CategoryLocale
{
    /**
     * Le nom
     * @var string
     */
    protected $name;

    /**
     * Fil d'ariane
     * @var string
     */
    protected $breadcrumb;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CategoryLocale
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * @param string $name
     * @return CategoryLocale
     */
    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
        return $this;
    }

}