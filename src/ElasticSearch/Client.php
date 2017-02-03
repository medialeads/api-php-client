<?php
namespace EuropeanSourcing\Api\ElasticSearch;

use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\ApiCallerInterface;
use EuropeanSourcing\Api\Transformer\TransformerInterface;

class Client
{
    /**
     * @var LoggingApiCaller
     */
    protected $apiCaller;

    /**
     * @var Transformer
     */
    protected $transformer;

    /**
     * @var string
     */
    protected $elasticUrl;

    /**
     * Constructor
     *
     * @param LoggingApiCaller $apiCaller
     * @param SearchRequestProvider $searchRequestProvider
     * @param Transformer $transformer
     * @param string $elasticUrl
     */
    public function __construct(ApiCallerInterface $apiCaller, TransformerInterface $transformer, $elasticUrl)
    {
        $this->elasticUrl = $elasticUrl;
        $this->apiCaller = $apiCaller;
        $this->transformer = $transformer;
    }

    /**
     * Search
     *
     * @param integer $offset
     * @param integer $limit
     */
    public function search(SearchRequest $searchRequest, $offset, $limit)
    {
        $results = $this->apiCaller->post($this->elasticUrl, array_merge(
            $searchRequest->getElasticparameters(),
            array(
                'offset' => $offset,
                'perpage' => $limit
            )
        ));

        return $this->transformer->search($results);
    }

    public function get($id)
    {

    }

    /**
     * Get lastModified
     *
     * @param SearchRequest $model
     */
    public function lastModified(SearchRequest $searchRequest)
    {
        $results = $this->apiCaller->post($this->elasticUrl . '/last-modified',
            $searchRequest->getElasticparameters()
        );

        return $this->transformer->lastModified($results);
    }

    /**
     * Get all categories
     *
     * @param string $schema
     */
    public function categories(SearchRequest $searchRequest, $schema = 'plain')
    {
        $categories = $this->apiCaller->post($this->elasticUrl.'/categories', array_merge(
            $searchRequest->getElasticparameters(),
            array(
                'cschema' => $schema,
            )
        ));

        return $this->transformer->categories($categories);
    }

    /**
     * Get all brands
     */
    public function brands(SearchRequest $searchRequest)
    {
        $brands = $this->apiCaller->post($this->elasticUrl.'/brands', $searchRequest->getElasticparameters());

        return $this->transformer->brands($brands);
    }
}
