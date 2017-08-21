# api-php-client

PHP api client to search in the Europeansourcing products database

* [Languages](#languages)
* [Installation](#installation)
* [Usage](#usage)


Installation
------------

Require [`europeansourcing/api-php-client`](https://packagist.org/packages/europeansourcing/api-php-client)
into your `composer.json` file:

``` json
composer require europeansourcing/api-php-client
```

Usage
-----

If you install in /api-php-client of your localhost, you can call [http://localhost/api-php-client/example](http://localhost/api-php-client/example) to see all examples.

Make sure you're in localhost in order to have the "dump" function available.

``` php
<?php
use EuropeanSourcing\Api\ElasticSearch\Client;
use EuropeanSourcing\Api\ElasticSearch\SearchRequest;
use EuropeanSourcing\Api\ApiCaller\CurlCaller;
use EuropeanSourcing\Api\Transformer\ArrayTransformer;

require '../vendor/autoload.php';

// Token given by EuropeanSourcing
$token = 'O5L2T01JWVR5GQ05KIZHJ63DB3TSTAY4';

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

// Do a search (see Client.php for the list of function)
$response = $client->search($searchRequest, 0, 1);

// array response
dump($response);
```

This is one of the simplier example. It does a search based on the content of $searchRequest and return a $results based on the transformer.
As we pass it through our "ArrayTransformer", we get back an array of $results.
You can pass your own Transformer to the $client

One of the transformer is the ModelTransformer. Instead of having json or array, it build a whole structure of instances.
You can copy/paste the model folder to your projects (if you want modifiy it) and then just change the namespace by yours :

``` php
// our transformer (build model from results)
$modelNamespace = '\\EuropeanSourcing\\Api\\Model\\';
$transformer = new ModelTransformer($modelNamespace);
```

To have all input parameters for the search, you can watch the SearchRequest file, all parameters are documented.

Low level API
-----

If you don't want to use SearchRequest/Client, Models, etc (bad idea, you should), you can directly call the URL.

You can use GET or POST

``` php
// search products + aggregations (facets)
http://ws.europeansourcing.com/api?q=pen&language=en&sort=price&s[]=1774&token=O5L2T01JWVR5GQ05KIZHJ63DB3TSTAY4

// categories
http://ws.europeansourcing.com/api/categories?q=pen&language=en&sort=price&s[]=1774&token=O5L2T01JWVR5GQ05KIZHJ63DB3TSTAY4

// brands
http://ws.europeansourcing.com/api/brands?q=pen&language=en&sort=price&s[]=1774&token=O5L2T01JWVR5GQ05KIZHJ63DB3TSTAY4

// date of last modification
http://ws.europeansourcing.com/api/last-modified?q=pen&language=en&sort=price&s[]=1774&token=O5L2T01JWVR5GQ05KIZHJ63DB3TSTAY4

// images (you should use http cache)
http://www.europeansourcing.com/products/{id_image}-400x400.jpg
```

Here is a list of the raw parameters : 

``` php
page => (int) page number
limit => (int) number of products per page
q => (string) text query
b => (integer) one brand id
s[] => (array) supplier ids
c[] => (array) category ids
a[] => (array) attribute ids
prix_min => (float) min price
prix_max => (float) max price
withstockonly => (integer 0|1) has stock
not_ids[] => (array) ids exclusion
ids[] => (array) ids inclusion
variantIds[] => (array) variant ids inclusion
withaggs => (integer 0|1) add aggregations (facets)
language => (string fr|en|de|it|es|nl|pt) language
aschema => (string plain|tree) schema for attributes
cschema => (string plain|tree) schema for categories
sort => (string random|price|update|score) sort
sens => (string asc|desc) sens
aop => (string or|and) attributes operator
cop => (string or|and) categories operator
```

Consider using an extension for chrome/firefox to inspect the Json (Jsonview for example)
