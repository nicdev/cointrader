<?php

namespace Cointrader;

/**
 * @class PrivateApi provides access to the authenticated API endpoints
 */

class PrivateApi implements PrivateApiClientInterface
{

    /**
     * @var $client must be an instance of Cointrader\ApiCaller
     */

    protected $client;

    /**
     * @var $key is the API key provided by Coinbase
     */

    protected $key;

    /**
     * @var $secret is the API secret provided by Coinbase or you on Coinbase's settings
     */

    protected $secret;

    /**
     * @var $key is the API passphrase provided by you on Coinbase's settings
     */

    protected $passphrase;

    /**
     * Creates a PrivateApi object to use the authenticated methods of the API
     *
     * @param Cointrader\ApiCaller $apiCaller  makes the actual requests to the API
     * @param string               $key        API key provided by Coinbase
     * @param string               $secret     API secret provided by Coinbase or you on Coinbase's settings
     * @param string               $passphrase API passphrase provided by you on Coinbase's settings
     */

    public function __construct(ApiCaller $apiCaller, $key, $secret, $passphrase)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->passphrase = $passphrase;
        $this->client = $apiCaller;
        $this->client->init(self::ENDPOINT_URL, ['key' => $this->key, 'secret' => $this->secret, 'passphrase' => $this->passphrase]);
    }

    /**
     * All accounts for the authenticated user, or a single
     * account if an ID is passed
     *
     * @param  string    $accountId (optional) limits the response to a single account
     * @return array     Account information
     */

    public function tradingAccounts($accountId = null)
    {
        $endpoint = $accountId ? "accounts/{$accountId}" : 'accounts';
        return $this->client->get($endpoint, [], true);
    }

    /**
     * Transaction history for an account
     *
     * @param  string     $accountId
     * @param  array      $pagination (optional)
     *
     * @return array      Transaction history for the account
     */

    public function accountHistory($accountId, $pagination = [])
    {
        $endpoint = "accounts/{$accountId}/ledger";
        return $this->client->get($endpoint, [], true);
    }

    /**
     * Fund holds for an account
     *
     * @param  string     $accountId
     * @param  array      $pagination (optional)
     *
     * @return array      Holds for the account
     */

    public function accountHolds($accountId, $pagination)
    {

    }

    /**
     * Place a trade order
     *
     * @param  array      $params Too many to list, see https://docs.gdax.com/#place-a-new-order.
     *                            The array keys must match the parameter name in the documentation
     *
     * @return array      Order infromation
     */

    public function placeOrder($params)
    {

    }

    /**
     * Cancels an open order
     *
     * @param  string     $orderId Order ID
     *
     * @return string     Cancellation success or failure
     */

    public function cancelOrder($orderId)
    {

    }


    /**
     * Cancels multiple open orders
     *
     * @param  string     $productId (optional) Specify to only cancell orders for a specific product
     *
     * @return array      List of IDs of cancelled orders
     */

    public function cancelAllOrders($productId)
    {

    }

    /**
     * List orders
     *
     * @param  array      $status     (optional) Specify one or more statuses, or "all".
     *                                Omitting the status defaults to open orders only.
     * @param  string     $productId  (optional) Only list orders for a specific product.
     * @param  array      $pagination (optional)
     *
     * @return array      List of orders matching the criteria
     */

    public function orders($status = [], $productId = null, $pagination = [])
    {

    }

    /**
     * Information for an order
     *
     * @param  string     $orderId ID of the order
     *
     * @return array      Information about the order
     */

    public function order($orderId)
    {

    }

    /**
     * List fills
     *
     * @param  string     $orderId    (optional) Limit the fills to a particular order
     * @param  string     $productId  (optional) Only list fills for a specific product.
     * @param  array      $pagination (optional)
     *
     * @return array      List of fills matching the criteria.
     */

    public function fills($orderId = null, $productId = null, $pagination = [])
    {

    }

    /**
     * Funding records for margin orders
     *
     * @param  string  $status     (optional) Defaults to all statuses
     * @param  array   $pagination
     *
     * @return array  List of funding records
     */

    public function funding($status = null, $pagination = [])
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
