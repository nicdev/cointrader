<?php

use PHPUnit\Framework\TestCase;
use Cointrader\ApiCaller;
use VCR\VCR;

class PrivateApiTest extends TestCase
{

    public function test_it_makes_a_call_to_accounts() {

      VCR::turnOn();
      VCR::insertCassette('accounts_endpoint.yml');

      $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

      $accounts = $this->privateApi->tradingAccounts();

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($accounts));
    }

    public function test_it_makes_a_call_to_account_holds() {

      VCR::turnOn();
      VCR::insertCassette('account_holds_endpoint.yml');

      $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

      $products = $this->privateApi->accountHolds(USD_ACCOUNT);

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($products));
    }

    public function test_it_makes_a_call_to_account_orders() {
      VCR::configure()->setCassettePath('private-tests/fixtures');
      VCR::turnOn();
      VCR::insertCassette('account_orders_endpoint.yml');

      $this->privateApi = new Cointrader\PrivateApi(new Cointrader\ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);

      $orders = $this->privateApi->orders();

      VCR::eject();
      VCR::turnOff();

      $this->assertTrue(is_array($orders));
    }
  }
