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
            // 'client_oid' => 'test order through PHPUnit',
            'type' => 'limit',
            'side' => 'buy',
            'product_id' => 'ETH-USD',
            'price' => '0.1',
            'size' => '1',
            'time_in_force' => 'GTC'
        ];

        // $orderParams = [
        //     "size" => "0.01",
        //     "price" => "0.100",
        //     "side" => "buy",
        //     "product_id" => "BTC-USD"
        // ];

        $order = $this->privateApi->placeOrder($orderParams);

        VCR::eject();
        VCR::turnOff();

        $this->assertTrue(is_array($order));
    }
  }
