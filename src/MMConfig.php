<?php

namespace Mataharimall;

class MMConfig
{
    protected $config;
    protected $defaultEnv = 'sandbox';
    protected $timeout = 5;
    protected $decodeAsArray = false;

    /**
     * Set environment (sandbox|prod).
     *
     * @param string $env
     */
    public function setEnv($env = null)
    {
        $defaultConfig = require __DIR__.'/../config/default.php';

        if (empty($defaultConfig[$env])) {
            $this->config = $defaultConfig[$this->defaultEnv];
        } else {
            $this->config = $defaultConfig[$env];
        }
    }

    /**
     *
     * @return config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set response as array.
     *
     * @param bool
     */
    public function setDecodeAsArray($value)
    {
        $this->decodeAsArray = (bool)$value;
    }

    /**
     * Set the connection and response timeouts.
     *
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int)$timeout;
    }
}
