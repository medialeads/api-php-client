<?php
namespace EuropeanSourcing\Api\ElasticSearch;


class Transformer
{
    /**
     * Met en forme la recherche principale
     *
     * @param array $results
     * @return ResultSet
     */
    public function search($results)
    {
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
        return $categories;
    }

    /**
     * Marques
     *
     * @param array $brands
     * @return array
     */
    public function brands($brands)
    {
        return $brands;
    }

    /**
     * Retourne la date du produit le plus récemment modifié pour une recherche précise
     *
     * @param string $results
     */
    public function lastModified($lastModified)
    {
        return $lastModified;
    }
}
