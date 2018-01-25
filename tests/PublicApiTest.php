<?php

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use VCR\VCR;

class PublicApiTest extends TestCase
{

    public function test_it_makes_a_call_to_products() {

      VCR::turnOn();
      VCR::insertCassette('products_endpoint.yml');

      $this->publicApi = new Cointrader\PublicApi(new ApiCaller);

      $products = $this->publicApi->products();

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($products));
    }

    public function test_it_makes_a_call_to_order_book() {
      VCR::turnOn();
      VCR::insertCassette('orderbook_endpoint.yml');

      $this->publicApi = new Cointrader\PublicApi(new ApiCaller);

      $orderBook = $this->publicApi->orderBook('BTC-USD', 1);

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($orderBook));
      $this->assertArrayHasKey('sequence', $orderBook);
      $this->assertArrayHasKey('bids', $orderBook);
      $this->assertArrayHasKey('asks', $orderBook);
    }
  }
