# api-php-client

Php api client to search in the Europeansourcing products database

* [Languages](#languages)
* [Installation](#installation)
* [Usage](#usage)


Installation
------------

Require [`medialeads/api-php-client`](https://packagist.org/packages/medialeads/api-php-client)
into your `composer.json` file:


``` json
{
    "require": {
        "medialeads/api-php-client": "dev-master"
    }
}
```

Usage
-----

In your code:

``` php
use EuropeanSourcing\Api\ElasticSearch\Client;
use EuropeanSourcing\Api\ElasticSearch\JsonTransformer;
use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;

require '../vendor/autoload.php';

// Api url
$url = 'http://search4.europeansourcing.com/api';
$token = 'xxxxxxxxxxxxxxxx';

// api caller
$apiCaller = new CurlCaller($token);

// data transformer
$transformer = new JsonTransformer();

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
```
