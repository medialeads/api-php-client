<?php
namespace EuropeanSourcing\Api\ApiCaller;

interface ApiCallerInterface
{
    /**
     * Send a post request
     *
     * @param string $url
     * @param array $data
     */
    public function post($url, $data);
}