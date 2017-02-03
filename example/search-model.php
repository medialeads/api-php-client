<?php
use EuropeanSourcing\Api\ElasticSearch\Client;
use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;
use EuropeanSourcing\Api\ModelBuilder;
use EuropeanSourcing\Api\Transformer\JsonTransformer;

require '../vendor/autoload.php';
require './config.php';

// api caller
$apiCaller = new CurlCaller($token);

/**
 * Data transformer
 * There are 2 transformer,
 *  - SimpleTransformer do nothing, use it to get original Json response
 *  - JsonTransformer decode json response in php array
 */
$transformer = new JsonTransformer();

// api client
// perform the call to API
$client = new Client($apiCaller, $transformer, $url);

// search request object
// Handle all parameters of your search
$searchRequest = new SearchRequest();
$searchRequest->setQuery('stylo');
$searchRequest->setLanguage('fr');

// Do a search, we get back here a php array
$response = $client->search($searchRequest, 0, 30);

// transform basic PHP array in usefull Models
$models = new ModelBuilder();

/**
 * if you copy/paste the Model folder in your project, you can
 * make your own Model, so give the namespace of your own model
 */
$modelNameSpace = '\\EuropeanSourcing\\Api\\Model\\Product';

$products = array();
foreach ($response['products'] as $product) {
    $products[] = $models->build($product, $modelNameSpace);
}

dump($products);
// get all categories for this search
/*$response = $client->categories($searchRequest, 'tree');
dump($response);

// get all brands for this search
$response = $client->brands($searchRequest);
dump($response);

// get datetime of last modified product of this search
$response = $client->lastModified($searchRequest);
dump($response);*/