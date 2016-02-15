<?php
namespace Mataharimall\Helpers;

class Curl
{
    protected $curl;

    public function init()
    {
        $this->curl = curl_init();
    }

    public function exec()
    {
        return curl_exec($this->curl);
    }

    public function setOptArray(array $options)
    {
        curl_setopt_array($this->curl, $options);
    }

    public function errno()
    {
        return curl_errno($this->curl);
    }

    public function error()
    {
        return curl_error($this->curl);
    }

    public function getinfo($type)
    {
        return curl_getinfo($this->curl, $type);
    }

    public function close()
    {
        return curl_close($this->curl);
    }

}
