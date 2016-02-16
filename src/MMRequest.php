<?php
namespace Mataharimall;

use Mataharimall\Helpers\Curl;
class MMRequest
{
    private $MMcurl;
    private $rawResponse;
    private $HttpCode;
    private $curlOptions;
    private $proxy = [];

    /**
     *
     * Constructor
     *
     */
    public function __construct(Curl $MMcurl = null)
    {
        $this->MMcurl = $MMcurl ?: new Curl();
    }

    /**
     * send HTTP Request
     *
     * @param string $url
     * @param string $method
     * @param string $authorization
     * @param array $fields
     *
     * @return string
     * @throws MMException
     */
    public function send($url, $method, $body, $headers, $timeout)
    {
        $this->openConnection($url, $method, $body, $headers, $timeout);
        $this->sendRequest();

        if ($this->MMcurl->errno() > 0) {
            throw new MMException($this->MMcurl->error(), $this->MMcurl->errno());
        }

        $this->HttpCode = $this->MMcurl->getinfo(CURLINFO_HTTP_CODE);
        $this->closeConnection();
        return $this->rawResponse;
    }

    protected function openConnection($url, $method, array $body, $headers, $timeout)
    {
        $options = [
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => $this->compileHeaders($headers),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip',
        ];

        if ($method == 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        }

        if (!empty($this->proxy)) {
            $options[CURLOPT_PROXY] = $this->proxy['CURLOPT_PROXY'];
            $options[CURLOPT_PROXYUSERPWD] = $this->proxy['CURLOPT_PROXYUSERPWD'];
            $options[CURLOPT_PROXYPORT] = $this->proxy['CURLOPT_PROXYPORT'];
            $options[CURLOPT_PROXYAUTH] = CURLAUTH_BASIC;
            $options[CURLOPT_PROXYTYPE] = CURLPROXY_HTTP;
        }

        $this->MMcurl->init();
        $this->setCurlOptions($options);
        $this->MMcurl->setOptArray($options);
    }

    public function setProxy(array $proxy)
    {
        if (!empty($proxy)) {
            $this->proxy = array_merge([
                'CURLOPT_PROXY' => '',
                'CURLOPT_PROXYUSERPWD' => '',
                'CURLOPT_PROXYPORT' => '',
            ], $proxy);
        }
    }

    public function setCurlOptions($options)
    {
        $this->curlOptions = $options;
    }

    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    public function getHttpCode()
    {
        return $this->HttpCode;
    }

    protected function closeConnection()
    {
        $this->MMcurl->close();
    }

    protected function sendRequest()
    {
        $this->rawResponse = $this->MMcurl->exec();
    }

    protected function compileHeaders($rawHeaders)
    {
        $headers = [];

        foreach ($rawHeaders as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }

        return $headers;
    }

}
