<?php

use PHPUnit\Framework\TestCase;

class PublicApiTest extends TestCase
{

    protected function setUp() {

    }

    public function tearDown() {
        Mockery::close();
    }

    public function test_it_makes_a_call_to_products() {
      $apiCaller = Mockery::mock('Cointrader\ApiCaller')->makePartial();
      $returnValue = json_encode(file_get_contents(__DIR__ . '/return_values/public_api/products.json'));
      $apiCaller->shouldReceive('get')->with(['products', []])->andReturn($returnValue);

      $this->publicApi = new Cointrader\PublicApi($apiCaller);

      $products = $this->publicApi->products();

      $this->assertTrue(is_array($products));
    }

    public function test_it_makes_a_call_to_order_book() {
      $apiCaller = Mockery::mock('Cointrader\ApiCaller')->makePartial();
      $returnValue = json_encode(file_get_contents(__DIR__ . '/return_values/public_api/order_book.json'));
      $apiCaller->shouldReceive('get')->with(['orderbook', ['BTC-USD', 1]])->andReturn($returnValue);

      $this->publicApi = new Cointrader\PublicApi($apiCaller);

      $orderBook = $this->publicApi->orderBook('BTC-USD', 1);

      $this->assertTrue(is_array($orderBook));
      $this->assertArrayHasKey('sequence', $orderBook);
      $this->assertArrayHasKey('bids', $orderBook);
      $this->assertArrayHasKey('asks', $orderBook);
    }
  }
