<?php
use EuropeanSourcing\Api\Client;
use EuropeanSourcing\Api\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;
use EuropeanSourcing\Api\Transformer\ArrayTransformer;

require '../vendor/autoload.php';
require './config.php';

// api caller
// perform the call to API
$apiCaller = new CurlCaller($token);

// data transformer
$transformer = new ArrayTransformer();

// api client
// organise the call to API, the transformation and the response
$client = new Client($apiCaller, $transformer, $url);

// search request object
// Handle all parameters of your search
$searchRequest = new SearchRequest();
$searchRequest->setQuery('stylo');
$searchRequest->setLanguage('fr');

// Do a search
$response = $client->search($searchRequest, 0, 10);

// array response
dump($response);