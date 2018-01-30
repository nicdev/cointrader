<?php

namespace CointraderTest;

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use Cointrader\PublicApi;
use VCR\VCR;

class PublicApiTest extends TestCase
{

    protected function setUp()
    {
        VCR::configure()->setCassettePath('tests/fixtures');
        VCR::configure()->setMode('once');
        VCR::configure()->enableRequestMatchers(['method', 'url', 'host']);
        VCR::turnOn();

        $this->publicApi = new PublicApi(new ApiCaller);
    }

    protected function tearDown()
    {
        VCR::eject();
        VCR::turnOff();
    }

    public function testGetsProducts()
    {
        VCR::insertCassette('products_endpoint.yml');

        $products = $this->publicApi->products();

        $this->assertTrue(is_array($products));
    }

    public function testGetsOrderBook()
    {
        VCR::insertCassette('order_book_endpoint.yml');

        $orderBook = $this->publicApi->orderBook('BTC-USD', 1);

        $this->assertTrue(is_array($orderBook));
        $this->assertArrayHasKey('sequence', $orderBook);
        $this->assertArrayHasKey('bids', $orderBook);
        $this->assertArrayHasKey('asks', $orderBook);
    }

    public function testGetsTicker()
    {
        VCR::insertCassette('ticker_endpoint.yml');

        $ticker = $this->publicApi->ticker('ETH-USD');

        $this->assertTrue(is_array($ticker));
    }
}
