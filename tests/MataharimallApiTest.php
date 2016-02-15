<?php

namespace Mataharimall;

use Mataharimall\API;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    protected $MM;

    protected function setup()
    {
        $this->MM = new API(API_TOKEN);
    }

    public function testGetMasterBrands()
    {
        $result = $this->MM->post('master/brands', array('page' => 1,'limit' => 5));
        $this->assertEquals(200, $this->MM->getLastHttpCode());
        return;
    }
}
