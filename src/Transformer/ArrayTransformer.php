<?php
namespace EuropeanSourcing\Api\Transformer;


class ArrayTransformer implements TransformerInterface
{
    /**
     * Met en forme la recherche principale
     *
     * @param array $results
     * @return ResultSet
     */
    public function search($results)
    {
        return json_decode($results, true);
    }

    /**
     * C'est tout
     *
     * @param array $categories
     * @return array
     */
    public function categories($categories)
    {
        return json_decode($categories, true);
    }

    /**
     * Marques
     *
     * @param array $brands
     * @return array
     */
    public function brands($brands)
    {
        return json_decode($brands, true);
    }

    /**
     * Retourne la date du produit le plus récemment modifié pour une recherche précise
     *
     * @param string $results
     */
    public function lastModified($lastModified)
    {
        return json_decode($lastModified, true);
    }
}
