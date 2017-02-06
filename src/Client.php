<?php
namespace EuropeanSourcing\Api;

use EuropeanSourcing\Api\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\ApiCallerInterface;
use EuropeanSourcing\Api\Transformer\TransformerInterface;

class Client
{
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;

    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * @var string
     */
    protected $elasticUrl;

    /**
     * Constructor
     *
     * @param ApiCallerInterface $apiCaller
     * @param TransformerInterface $transformer
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
     * @param SearchRequest $searchRequest
     * @param integer $offset
     * @param integer $limit
     * @return mixed
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

    /**
     * Get lastModified
     *
     * @param SearchRequest $searchRequest
     * @return mixed
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
     * @param SearchRequest $searchRequest
     * @param string $schema
     * @return mixed
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
     *
     * @param SearchRequest $searchRequest
     * @return mixed
     */
    public function brands(SearchRequest $searchRequest)
    {
        $brands = $this->apiCaller->post($this->elasticUrl.'/brands', $searchRequest->getElasticparameters());

        return $this->transformer->brands($brands);
    }
}
