<?php

namespace Mataharimall;

use Mataharimall\Mataharimall;
use Mataharimall\MMRequest;

class MataharimallApiTest extends \PHPUnit_Framework_TestCase
{
    protected $MM;
    protected $result;

    protected function setup()
    {
        $this->MM = new Mataharimall(API_TOKEN);
        //test POST API
        $this->MM->setDecodeAsArray(true);
        $this->result = $this->MM->post('master/brands', [
            'page' => 1,
            'limit' => 5,
        ]);
    }

    public function testGetLastHttpCode()
    {
        $this->assertEquals(200, $this->MM->getResponseCode());
    }

    public function testGetLastHeaders()
    {
        $headers = $this->MM->getResponseHeaders();
        $this->assertInternalType('array', $headers);
    }

    public function testGetLastBody()
    {
        $body = $this->MM->getResponseBody();
        $this->assertArrayHasKey('code', $body);
        $this->assertArrayHasKey('results', $body);
        foreach ($body as $key => $value) {
            if ($key == 'code') {
                $this->assertEquals(200, $value);
            }
        }
    }

    public function testEmptyToken()
    {
        $this->setExpectedException('Mataharimall\MMException');
        try {
            $this->MM = new Mataharimall();
            $this->result = $this->MM->post('master/colors', []);
         } catch (Mataharimall\MMException $e) {
             $this->assertContains('Invalid API token.', $e->getMessage());
             throw $e;
         }
    }

    public function testCurlProxy()
    {
        $request = new MMRequest();
        $request->setProxy([
            'CURLOPT_PROXY' => PROXY_HOST,
            'CURLOPT_PROXYPORT' => PROXY_PORT,
        ]);
        $this->MM = new Mataharimall(API_TOKEN, $request);
        $result = $this->MM->post('master/colors', []);
        $fields = $request->getCurlOptions();
        $this->assertEquals($fields[CURLOPT_PROXY], PROXY_HOST);
    }

    public function testSwitchEnviroment()
    {
        $this->MM->setEnv('prod');
        $config = $this->MM->getConfig();
        $this->assertEquals($config['host'], PROD_HOST);
    }

}
