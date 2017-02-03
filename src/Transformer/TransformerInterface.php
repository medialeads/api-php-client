<?php
namespace EuropeanSourcing\Api\Transformer;

interface TransformerInterface
{
    public function search($results);

    public function categories($categoires);

    public function brands($brands);

    public function lastModified($lastModified);
}