<?php
namespace Mataharimall;

class MMResponse
{
    private $apiPath;
    private $httpCode = 0;
    private $headers = [];
    private $body = [];

    /**
     * @param string $apiPath
     */
    public function setApiPath($apiPath)
    {
        $this->apiPath = $apiPath;
    }

    /**
     * @return string|null
     */
    public function getApiPath()
    {
        return $this->apiPath;
    }

    /**
     * @param array|object $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return array|object|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param int $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function setHeaders($header)
    {
        $headers = [];
        foreach (explode("\r\n", $header) as $line) {
            if (strpos($line, ':') !== false) {
                list ($key, $value) = explode(': ', $line);
                $key = str_replace('-', '_', strtolower($key));
                $headers[$key] = trim($value);
            }
        }
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

}
