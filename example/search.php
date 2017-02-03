<?php
use EuropeanSourcing\Api\ElasticSearch\Client;
use EuropeanSourcing\Api\ElasticSearch\Transformer;
use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;

require '../vendor/autoload.php';

$url = 'http://search.europeansourcing.local/app_dev.php/api';
$token = 'BPDF5FVQ4GXXBW6FAXWZF7RI5ID5HGJ1';

// api caller
$apiCaller = new CurlCaller($token);

// data transformer
$transformer = new Transformer();

// api client
$client = new Client($apiCaller, $transformer, $url);

// search request object
$searchRequest = new SearchRequest();
$searchRequest->setQuery('stylo');

// Do a search
$response = $client->search($searchRequest, 1, 30);
dump($response);

$response = $client->categories($searchRequest, 'tree');
dump($response);

$response = $client->brands($searchRequest);
dump($response);

$response = $client->lastModified($searchRequest);
dump($response);