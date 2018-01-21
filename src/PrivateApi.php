<?php

namespace Cointrader;

/**
 *
 */

class PrivateApi implements PrivateApiClientInterface
{

    protected $client;
    protected $key;
    protected $secret;
    protected $passphrase;


    public function __construct(ApiCaller $apiCaller, $key, $secret, $passphrase)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->passphrase = $passphrase;
        $this->client = $apiCaller;
        $this->client->init(self::ENDPOINT_URL, ['key' => $this->key, 'secret' => $this->secret, 'passphrase' => $this->passphrase]);
    }

    public function tradingAccounts($accountId = null)
    {
        $endpoint = $accountId ? "accounts/{$accountId}" : 'accounts';
        return $this->client->get($endpoint, [], true);
    }

    public function accountHistory($accountId, $pagination = [])
    {
        $endpoint = "accounts/{$accountId}/ledger";
        return $this->client->get($endpoint, [], true);
    }

    public function accountHolds($accountId, $pagination)
    {

    }

    public function placeOrder($params)
    {

    }

    public function cancelOrder($orderId)
    {

    }

    public function cancelAllOrders($productId)
    {

    }

    public function orders($params)
    {

    }

    public function order($orderId)
    {

    }

    public function fills($params)
    {

    }

    public function funding($status)
    {

    }

    public function repay($params)
    {

    }

    public function marginTransfer($params)
    {

    }

    public function position()
    {

    }

    public function closePosition($repayOnly)
    {

    }

    public function deposit($params)
    {

    }

    public function coinbaseTransfer($params)
    {

    }

    public function withdraw($params)
    {

    }

    public function coinbaseWithdraw($params)
    {

    }

    public function withdrawCrypto($params)
    {

    }

    public function paymentMethods()
    {

    }

    public function coinbaseAccounts()
    {

    }

    public function createReport($params)
    {

    }

    public function reportStatus($reportId)
    {

    }

    public function trailingVolume()
    {

    }

}
