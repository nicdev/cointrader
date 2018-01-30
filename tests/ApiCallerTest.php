<?php

namespace CointraderTest;

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use VCR\VCR;

class ApiCallerTest extends TestCase
{

    protected function setUp()
    {
        VCR::configure()->setCassettePath('tests/fixtures');
        VCR::configure()->setMode('once');
        VCR::configure()->enableRequestMatchers(['method', 'url', 'host']);
        VCR::turnOn();

        $this->apiCaller = new ApiCaller;
        $this->apiCaller->init(ENDPOINT_URL);
    }

    protected function tearDown()
    {
        VCR::eject();
        VCR::turnOff();
    }

    public function testGetsApiTime()
    {
        VCR::insertCassette('time_endpoint.yml');

        $time = $this->apiCaller->get('time', []);

        $this->assertTrue(is_array($time));
        $this->assertArrayHasKey('iso', $time);
        $this->assertArrayHasKey('epoch', $time);
    }
}
