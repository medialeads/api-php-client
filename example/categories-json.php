<?php
use EuropeanSourcing\Api\ElasticSearch\Client;
use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;
use EuropeanSourcing\Api\Transformer\SimpleTransformer;

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
$transformer = new SimpleTransformer();

// api client
// perform the call to API
$client = new Client($apiCaller, $transformer, $url);

// search request object
// Handle all parameters of your search
$searchRequest = new SearchRequest();
$searchRequest->setQuery('stylo');
$searchRequest->setLanguage('fr');

// Do a search, we get back here a php array
$response = $client->categories($searchRequest, 'plain');
dump($response);
