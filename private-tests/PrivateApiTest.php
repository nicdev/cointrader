<?php

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use VCR\VCR;

class PrivateApiTest extends TestCase
{

    public function test_it_makes_a_call_to_accounts() {

      VCR::configure()->setCassettePath('private-tests/fixtures');
      VCR::turnOn();
      VCR::insertCassette('accounts_endpoint.yml');

      $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

      $accounts = $this->privateApi->tradingAccounts();

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($accounts));
    }

    public function test_it_makes_a_call_to_account_holds() {
      VCR::configure()->setCassettePath('private-tests/fixtures');
      VCR::turnOn();
      VCR::insertCassette('account_holds_endpoint.yml');

      $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

      $products = $this->privateApi->accountHolds(USD_ACCOUNT);

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($products));
    }

    public function test_it_places_a_buy_limit_order() {
        VCR::configure()->setCassettePath('private-tests/fixtures');
        VCR::turnOn();
        VCR::insertCassette('account_place_order_endpoint.yml');

        $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

        $orderParams = [
            'type' => 'limit',
            'side' => 'buy',
            'product_id' => 'ETH-USD',
            'price' => '0.1',
            'size' => '1',
            'time_in_force' => 'GTC'
        ];

        $order = $this->privateApi->placeOrder($orderParams);

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($order));

        return $order['id'];
    }


    /**
     * @depends test_it_places_a_buy_limit_order
     */

    public function test_it_gets_order_info() {
        VCR::configure()->setCassettePath('private-tests/fixtures');
        VCR::turnOn();
        VCR::insertCassette('account_get_order_info_endpoint.yml');

        $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

        $order = $this->privateApi->order($orderId);

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($order));
    }

    /**
     * @depends test_it_places_a_buy_limit_order
     */

    public function test_it_cancels_an_order($orderId) {
        VCR::configure()->setCassettePath('private-tests/fixtures');
        VCR::turnOn();
        VCR::insertCassette('account_delete_order_endpoint.yml');

        $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

        $order = $this->privateApi->cancelOrder($orderId);

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($order));
    }

    public function test_it_cancels_all_eth_orders() {
        VCR::configure()->setCassettePath('private-tests/fixtures');
        VCR::turnOn();
        VCR::insertCassette('account_delete_all_eth_orders_endpoint.yml');

        $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

        $order = $this->privateApi->cancelAllOrders('ETH-USD');

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($order));
    }
  }
