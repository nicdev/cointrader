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
        VCR::configure()->setMode('once');
        VCR::configure()->enableRequestMatchers(['method', 'url', 'host']);
        VCR::turnOn();

        $this->privateApi = new PrivateApi(new ApiCaller, API_KEY, API_SECRET, API_PASSPHRASE);
    }

    protected function tearDown()
    {
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * Finds the first bank account in a collection of accounts
     * @method findBankAccount
     * @param  array          $accounts a collection of accounts from method paymentMethods()
     * @return array          A single bank account
     */

    protected function findBankAccount($accounts)
    {
        foreach ($accounts as $a) {
            if ($a['type'] === 'ach_bank_account') {
                return $a;
            }
        }
    }

    /**
     * Finds the first Coinbase account for the given currency
     * @method findCoibaseAccountByCurrency
     * @param  string                       $currency a currency symbol (e.g. USD, BTC, ETH, etc.)
     * @return array                        Account information
     */


    protected function findCoibaseAccountByCurrency($accounts, $currency)
    {
        foreach ($accounts as $a) {
            if (strtolower($a['currency']) === strtolower($currency)) {
                return $a;
            }
        }
    }

    public function testItGetsAccounts()
    {
        VCR::insertCassette('accounts_endpoint.yml');

        $accounts = $this->privateApi->tradingAccounts();
        var_dump($accounts);
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

        $fills = $this->privateApi->fills();

        $this->assertTrue(is_array($fills));
    }

    public function testItGetsFundings()
    {
        VCR::insertCassette('fundings_endpoint.yml');

        $fundings = $this->privateApi->fundings();

        $this->assertTrue(is_array($fundings));
    }

    public function testItGetsPosition()
    {
        VCR::insertCassette('position_endpoint.yml');

        $position = $this->privateApi->position();

        $this->assertTrue(is_array($position));
    }

    public function testItGetsPaymentMethods()
    {
        VCR::insertCassette('payment_methods_endpoint.yml');

        $paymentMethods = $this->privateApi->paymentMethods();

        $this->assertTrue(is_array($paymentMethods));

        return self::findBankAccount($paymentMethods);
    }

    /**
     * @depends testItGetsPaymentMethods
     *
     * @note    the minimum transfer is $10, so this can get expensive in testing
     *          if you don't record the HTTP request.
     */

    public function testItMakesADepositFromBank($bankAccount)
    {
        VCR::insertCassette('deposit_endpoint.yml');

        $params = [
            'amount' => '10.00',
            'currency' => $bankAccount['currency'],
            'payment_method_id' => $bankAccount['id']
        ];

        $deposit = $this->privateApi->deposit($params);

        $this->assertTrue(is_array($deposit));
    }

    public function testItGetsCoinbaseAccounts()
    {
        VCR::insertCassette('coinbase_accounts_endpoint.yml');

        $accounts = $this->privateApi->coinbaseAccounts();

        $this->assertTrue(is_array($accounts));

        return self::findCoibaseAccountByCurrency($accounts, 'USD');
    }

    /**
     * @depends testItGetsCoinbaseAccounts
     */

    public function testItTransfersToCoinbase($coinbaseAccount)
    {
        VCR::insertCassette('coinbase_withdrawl_endpoint.yml');

        $params = [
            'amount' => '1.00',
            'currency' => $coinbaseAccount['currency'],
            'coinbase_account_id' => $coinbaseAccount['id']
        ];

        $accounts = $this->privateApi->coinbaseWithdraw($params);

        $this->assertTrue(is_array($accounts));
    }

    /**
     * @depends testItGetsCoinbaseAccounts
     */

    public function testItTransfersFromCoinbase($coinbaseAccount)
    {
        VCR::insertCassette('coinbase_transfer_endpoint.yml');

        $params = [
            'amount' => '1.00',
            'currency' => $coinbaseAccount['currency'],
            'coinbase_account_id' => $coinbaseAccount['id']
        ];

        $accounts = $this->privateApi->coinbaseTransfer($params);

        $this->assertTrue(is_array($accounts));
    }

    public function testCreateReport()
    {
        VCR::insertCassette('create_report_endpoint.yml');

        $params = [
            'type' => 'fills',
            'start_date' => '2017-01-01T00:00:00.000Z',
            'end_date' => '2017-12-31T00:00:00.000Z',
            'product_id' => 'USD-ETH',
            'email' => 'nic@epiclabs.com'
        ];

        $report = $this->privateApi->createReport($params);

        $this->assertTrue(is_array($report));

        return $report;
    }

    /**
     * @depends testCreateReport
     */

    public function testGetsReportStatus($report)
    {
        VCR::insertCassette('report_status_endpoint.yml');

        $reportStatus = $this->privateApi->reportStatus($report['id']);

        $this->assertTrue(is_array($reportStatus));
    }

    public function testGetTrailingVolume()
    {
        VCR::insertCassette('trailing_volume_endpoint');

        $trailingVolume = $this->privateApi->trailingVolume();

        $this->assertTrue(is_array($trailingVolume));
    }
}
