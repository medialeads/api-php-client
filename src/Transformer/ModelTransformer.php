<?php
namespace EuropeanSourcing\Api\Transformer;

class ModelTransformer implements TransformerInterface
{
    /**
     * @var ModelBuilder
     */
    private $modelBuilder;

    /**
     * @var string
     */
    private $modelNamespace;

    /**
     * Constructor
     *
     * @param string $modelNamespace
     */
    public function __construct($modelNamespace)
    {
        $this->modelBuilder = new ModelBuilder();
        $this->modelNamespace = $modelNamespace;
    }

    /**
     * Met en forme la recherche principale
     *
     * @param array $results
     * @return ResultSet
     */
    public function search($results)
    {
        $results = json_decode($results, true);

        // products
        $products = [];
        foreach ($results['products'] as $product) {
            $products[] = $this->modelBuilder->build($product, $this->modelNamespace . 'Product');
        }
        $results['products'] = $products;

        // categories
        $categories = [];
        foreach ($results['categories'] as $category) {
            $categories[] = $this->modelBuilder->build($category, $this->modelNamespace . 'Category');
        }
        $results['categories'] = $categories;

        // attributes
        $attributes = [];
        foreach ($results['attributes'] as $attributeGroup) {
            $attributes[] = $this->modelBuilder->build($attributeGroup, $this->modelNamespace . 'AttributeGroup');
        }
        $results['attributes'] = $attributes;

        // brands
        $brands = [];
        foreach ($results['brands'] as $brand) {
            $brands[] = $this->modelBuilder->build($brand, $this->modelNamespace . 'Brand');
        }
        $results['brands'] = $brands;

        return $results;
    }

    /**
     * C'est tout
     *
     * @param array $categories
     * @return array
     */
    public function categories($categories)
    {
        $categories = json_decode($categories, true);

        // categories
        $modelCategories = [];
        foreach ($categories as $category) {
            $modelCategories[] = $this->modelBuilder->build($category, $this->modelNamespace . 'Category');
        }

        return $modelCategories;
    }

    /**
     * Marques
     *
     * @param array $brands
     * @return array
     */
    public function brands($brands)
    {
        $brands = json_decode($brands, true);

        // categories
        $modelBrands = [];
        foreach ($brands as $brand) {
            $modelBrands[] = $this->modelBuilder->build($brand, $this->modelNamespace . 'Brand');
        }

        return $modelBrands;
    }

    /**
     * Retourne la date du produit le plus récemment modifié pour une recherche précise
     *
     * @param string $results
     */
    public function lastModified($lastModified)
    {
        return json_decode($lastModified);
    }
}
