<?php
use EuropeanSourcing\Api\Client;
use EuropeanSourcing\Api\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;
use EuropeanSourcing\Api\Transformer\ModelTransformer;

require '../vendor/autoload.php';
require './config.php';

// api caller
$apiCaller = new CurlCaller($token);

// our transformer (build model from results)
$modelNamespace = '\\EuropeanSourcing\\Api\\Model\\';
$transformer = new ModelTransformer($modelNamespace);

// api client
// perform the call to API
$client = new Client($apiCaller, $transformer, $url);

// search request object
// Handle all parameters of your search
$searchRequest = new SearchRequest();
$searchRequest->setQuery('stylo');
$searchRequest->setLanguage('fr');

// Do a search, we get back an array of models instances
$response = $client->search($searchRequest, 0, 10);
dump($response);