<?php
namespace EuropeanSourcing\Api\ApiCaller;

class CurlCaller implements ApiCallerInterface
{
    /**
     * Http headers
     * @var array
     */
    private $headers;

    /**
     * Constructor
     *
     * @param array $headers
     */
    public function __construct($token)
    {
        $this->headers = array(
            'X-AUTH-TOKEN: '.$token
        );
    }

    /**
     * {@inheritDoc}
     * @see \EuropeanSourcing\Api\ApiCaller\ApiCallerInterface::post()
     */
    public function post($url, $data)
    {
        $requestData = http_build_query($data);

        $s = curl_init();
        curl_setopt($s, CURLOPT_URL, $url);
        curl_setopt($s, CURLOPT_POST, 1);
        curl_setopt($s, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($s);
        $httpcode = curl_getinfo($s, CURLINFO_HTTP_CODE);
        curl_close($s);

        if ( ($httpcode < 200) || ($httpcode > 299) ) {
            throw new ApiCallerException($this->getStatus($httpcode), $httpcode);
        }

        return $response;
    }

    /**
     * Get the HTTP status message by HTTP status code
     *
     * @return mixed HTTP status message (string) or the status code (integer) if the message can't be found
     */
    public function getStatus($code)
    {
        $codes = array(
            0   => 'Connection failed',
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
        );

        if (isset($codes[$code])) {
            return "$code $codes[$code]";
        }

        return $code;
    }
}