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

    public function testGetsTrades()
    {
        VCR::insertCassette('trades_endpoint.yml');

        $trades = $this->publicApi->ticker('ETH-USD');

        $this->assertTrue(is_array($trades));
    }

    public function testGetsHistory()
    {
        VCR::insertCassette('history_endpoint.yml');

        $history = $this->publicApi->history([
            product => 'ETH-USD',
            start => '2018-01-01T00:00:00+00:00'
        ]);

        $this->assertTrue(is_array($history));
    }

    public function testsGetStats()
    {
        VCR::insertCassette('stats_endpoint.yml');

        $stats = $this->publicApi->stats('ETH-USD');

        $this->assertTrue(is_array($stats));
    }

    public function testsGetCurrencies()
    {
        VCR::insertCassette('currencies_endpoint.yml');

        $currencies = $this->publicApi->currencies();

        $this->assertTrue(is_array($currencies));
    }
}
