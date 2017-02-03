<?php
use EuropeanSourcing\Api\ElasticSearch\Client;
use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;
use EuropeanSourcing\Api\ModelBuilder;
use EuropeanSourcing\Api\Transformer\JsonTransformer;

require '../vendor/autoload.php';
require './config.php';

// api caller
// perform the call to API
$apiCaller = new CurlCaller($token);

/*
 * Data transformer
 * There are 2 transformer,
 *  - SimpleTransformer do nothing, use it to get original Json response
 *  - JsonTransformer decode json response in php array
 */
$transformer = new JsonTransformer();

// api client
// organise the call to API, the transformation and the response
$client = new Client($apiCaller, $transformer, $url);

// search request object
// Handle all parameters of your search
$searchRequest = new SearchRequest();
$searchRequest->setQuery('stylo');
$searchRequest->setLanguage('fr');

// Do a search
$response = $client->brands($searchRequest);

// transform basic PHP array in usefull Models
$models = new ModelBuilder();

/**
 * if you copy/paste the Model folder in your project, you can
 * make your own Model, so give the namespace of your own model
 */
$modelNameSpace = '\\EuropeanSourcing\\Api\\Model\\Brand';

$brands = array();
foreach ($response as $brand) {
    $brands[] = $models->build($brand, $modelNameSpace);
}

dump($brands);