<?php

namespace CointraderTest;

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use Cointrader\PublicApi;
use VCR\VCR;

class PublicApiTest extends TestCase
{

    public function testGetsProducts()
    {

        VCR::turnOn();
        VCR::insertCassette('products_endpoint.yml');

        $this->publicApi = new PublicApi(new ApiCaller);

        $products = $this->publicApi->products();

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($products));
    }

    public function testGetsOrderBook()
    {
        VCR::turnOn();
        VCR::insertCassette('orderbook_endpoint.yml');

        $this->publicApi = new PublicApi(new ApiCaller);

        $orderBook = $this->publicApi->orderBook('BTC-USD', 1);

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($orderBook));
        $this->assertArrayHasKey('sequence', $orderBook);
        $this->assertArrayHasKey('bids', $orderBook);
        $this->assertArrayHasKey('asks', $orderBook);
    }
}
