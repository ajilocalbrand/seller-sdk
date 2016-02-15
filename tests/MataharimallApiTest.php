<?php

namespace Mataharimall;

use Mataharimall\API;
use Mataharimall\MMRequest;

class MataharimallApiTest extends \PHPUnit_Framework_TestCase
{
    protected $MM;
    protected $result;

    protected function setup()
    {
        $this->MM = new API(API_TOKEN);
        //test POST API
        $this->result = $this->MM->post('master/brands', [
            'page' => 1,
            'limit' => 5,
        ]);
    }

    public function testGetLastHttpCode()
    {
        $this->assertEquals(200, $this->MM->getLastHttpCode());
    }

    public function testGetLastHeaders()
    {
        $headers = $this->MM->getLastHeaders();
        $this->assertInternalType('array', $headers);
    }

    public function testGetLastBody()
    {
        $body = $this->MM->getLastBody();
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
            $this->MM = new API();
            $this->result = $this->MM->post('master/colors', []);
         } catch (Mataharimall\MMException $e) {
             $this->assertContains('Invalid API token.', $e->getMessage());
             throw $e;
         }
    }

    public function testCurlProxy()
    {
        $request = new MMRequest([
            'CURLOPT_PROXY' => PROXY_HOST,
            'CURLOPT_PROXYPORT' => PROXY_PORT,
        ]);
        $this->MM = new API(API_TOKEN, $request);
        $result = $this->MM->post('master/colors', []);
        $fields = $request->getCurlOptions();
        $this->assertEquals($fields[CURLOPT_PROXY], PROXY_HOST);

    }


}
