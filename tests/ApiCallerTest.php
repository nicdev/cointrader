<?php

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use VCR\VCR;

class ApiCallerTest extends TestCase
{

    protected function setUp()
    {
        $this->public_endpoint = 'https://api.gdax.com';
    }

    public function test_it_makes_a_get_request_to_coinbase_api_time_endpoint() {

      VCR::turnOn();
      VCR::insertCassette('time_endpoint.yml');

      $apiCaller = new ApiCaller;
      $apiCaller->init($this->public_endpoint);

      $time = $apiCaller->get('time', []);

      $this->assertTrue(is_array($time));
      $this->assertArrayHasKey('iso', $time);
      $this->assertArrayHasKey('epoch', $time);

      VCR::eject();
      VCR::turnOff();

    }
  }
