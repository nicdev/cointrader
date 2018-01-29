<?php

namespace CointraderTest;

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use Cointrader\PrivateApi;
use VCR\VCR;

class PrivateApiTest extends TestCase
{
    protected function setUp()
    {
        VCR::configure()->setCassettePath('private-tests/fixtures');
        VCR::turnOn();
        $this->privateApi = new PrivateApi(new ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);
    }

    protected function tearDown()
    {
        VCR::eject();
        VCR::turnOff();
    }

    public function testItGetsAccounts()
    {
        VCR::insertCassette('accounts_endpoint.yml');

        $accounts = $this->privateApi->tradingAccounts();

        $this->assertTrue(is_array($accounts));
    }

    public function testItGetsAccountHolds()
    {
        VCR::insertCassette('account_holds_endpoint.yml');

        $products = $this->privateApi->accountHolds(USD_ACCOUNT);

        $this->assertTrue(is_array($products));
    }

    public function testItPlacesABuyLimitOrder()
    {
        VCR::insertCassette('account_place_order_endpoint.yml');

        $orderParams = [
            'type' => 'limit',
            'side' => 'buy',
            'product_id' => 'ETH-USD',
            'price' => '0.1',
            'size' => '1',
            'time_in_force' => 'GTC'
        ];

        $order = $this->privateApi->placeOrder($orderParams);

        $this->assertTrue(is_array($order));

        return $order['id'];
    }


    /**
     * @depends testItPlacesABuyLimitOrder
     */

    public function testItGetsOrderInfo($orderId)
    {
        VCR::insertCassette('account_get_order_info_endpoint.yml');

        $order = $this->privateApi->order($orderId);

        $this->assertTrue(is_array($order));
    }


    /**
     * @depends testItPlacesABuyLimitOrder
     */

    public function testItGetsAllOrdersInfo()
    {
        VCR::insertCassette('account_get_all_orders_info_endpoint.yml');

        $orders = $this->privateApi->orders('all');

        $this->assertTrue(is_array($orders));
    }

    /**
     * @depends testItPlacesABuyLimitOrder
     */

    public function testItCancelsAnOrder($orderId)
    {
        VCR::insertCassette('account_delete_order_endpoint.yml');

        $order = $this->privateApi->cancelOrder($orderId);

        $this->assertTrue(is_array($order));
    }

    /**
     * @depends testItPlacesABuyLimitOrder
     */

    public function testItCancelsAllEthOrders()
    {
        VCR::insertCassette('account_delete_all_eth_orders_endpoint.yml');

        $order = $this->privateApi->cancelAllOrders('ETH-USD');

        $this->assertTrue(is_array($order));
    }

    public function testItGetsOrderFills()
    {
        VCR::insertCassette('order_fills_endpoint.yml');

        $fills = $this->provateApi->fills();

        $this->assertTrue(is_array($fills));
    }

}
