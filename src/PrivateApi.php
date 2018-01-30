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
        $this->client->init(
            self::ENDPOINT_URL,
            ['key' => $this->key, 'secret' => $this->secret, 'passphrase' => $this->passphrase]
        );
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
        return $this->client->getPrivate($endpoint, [], true);
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
        return $this->client->getPrivate($endpoint, []);
    }

    /**
     * Fund holds for an account
     *
     * @param  string     $accountId
     * @param  array      $pagination (optional)
     *
     * @return array      Holds for the account
     */

    public function accountHolds($accountId, $pagination = [])
    {
        $endpoint = "accounts/{$accountId}/holds";
        return $this->client->getPrivate($endpoint, []);
    }

    /**
     * Place a trade order.
     *
     * @param  array      $params Too many to list, see https://docs.gdax.com/#place-a-new-order.
     *                            The array keys must match the parameter name in the documentation
     *
     * @todo              Analyze order parameters, and prevent placement if invalid
     *
     * @return array      Order infromation
     */

    public function placeOrder($params)
    {
        $endpoint = 'orders';
        return $this->client->postPrivate($endpoint, $params);
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
        $endpoint = "orders/{$orderId}";
        return $this->client->deletePrivate($endpoint);
    }


    /**
     * Cancels multiple open orders
     *
     * @param  string     $productId (optional) Specify to only cancell orders for a specific product
     *
     * @return array      List of IDs of cancelled orders
     */

    public function cancelAllOrders($productId = null)
    {
        $endpoint = "orders/?{$productId}";
        return $this->client->deletePrivate($endpoint);
    }

    /**
     * List orders
     *
     * @param  array      $status     (optional) Specify one or more statuses, or "all".
     *                                Omitting the status defaults to open orders only.
     * @todo              Allow passing multiple statuses
     * @param  string     $productId  (optional) Only list orders for a specific product.
     * @param  array      $pagination (optional)
     *
     * @return array      List of orders matching the criteria
     */

    public function orders($status = null, $productId = null, $pagination = [])
    {
        if ($status) {
            $query['status'] = $status;
        }

        if ($productId) {
            $query['product_id'] = $productId;
        }

        $query = count($query) > 0 ? array_merge($query, $pagination) : $pagination;

        return $this->client->getPrivate('orders', $query);
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
        $endpoint = "orders/{$orderId}";
        return $this->client->getPrivate($endpoint, []);
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
        if ($orderId) {
            $query['order_id'] = $orderId;
        }

        if ($productId) {
            $query['product_id'] = $productId;
        }

        $query = count($query) > 0 ? array_merge($query, $pagination) : $pagination;

        return $this->client->getPrivate('orders', $query);
    }

    /**
     * Funding records for margin orders
     *
     * @param  string  $status     (optional) Defaults to all statuses
     * @param  array   $pagination
     *
     * @return array  List of funding records
     */

    public function fundings($status = null, $pagination = [])
    {
        if ($status) {
            $query['status'] = $status;
        }

        $query = count($query) > 0 ? array_merge($query, $pagination) : $pagination;

        return $this->client->getPrivate('funding', $query);
    }

    /**
     * Repays funding records. Older gets paid first.
     *
     * @param  mixed   integer|float $amount
     * @param  string  string $currency       Currency symbol (e.g USD)
     *
     * @todo   review this method against the API, provide meaningful return values
     * @return string  result of transaction
     */

    public function repay($params)
    {

    }

    /**
     * Transfer funds between a standard account, and a margin  account
     * or vice versa.
     *
     * @param  array      $params See https://docs.gdax.com/#margin-transfer
     *
     * @return array      Result of the transfer transaction.
     */

    public function marginTransfer($params)
    {

    }

    /**
     * Provides an overview of the account
     *
     * @return array    Accounts, margins, status, etc.
     */

    public function position()
    {

    }

    /**
     * Closes a position
     *
     * @param  bool        $repayOnly
     * @todo   review this method against the API, provide meaningful return values
     *
     * @return string      Status of the transaction
     */

    public function closePosition($repayOnly)
    {

    }

    /**
     * Make a deposit from one of the available payment methods
     *
     * @param  array   $params amount, currency, payment method ID. See https://docs.gdax.com/#deposits
     *
     * @return array   Information regarding the transaction.
     */

    public function deposit($params)
    {

    }

    /**
     * Transfer funds from Coinbase to GDAX
     *
     * @param  array        $params Amount, currency, coinbase account id
     *
     * @return array        Transaction information.
     */

    public function coinbaseTransfer($params)
    {

    }

    /**
     * Transfer funds from GDAX to an external account
     *
     * @param  array        $params Amount, currency, payment method id
     *
     * @return array        Transaction information.
     */

    public function withdraw($params)
    {

    }

    /**
     * Transfer funds from GDAX to Coinbase
     *
     * @param  array        $params Amount, currency, coinbase account id
     *
     * @return array        Transaction information.
     */

    public function coinbaseWithdraw($params)
    {

    }

    /**
     * Transfer funds from GDAX to a crypto address
     *
     * @param  array        $params Amount, currency, crypto address
     *
     * @return array        Transaction information.
     */

    public function withdrawCrypto($params)
    {

    }

    /**
     * List of available payment methods
     *
     * @return array         Payment methods inormation.
     */

    public function paymentMethods()
    {

    }

    /**
     * List of Coinbase accounts
     *
     * @return array         Accounts information.
     */

    public function coinbaseAccounts()
    {

    }

    /**
     * Create a report
     *
     * @param  array       $params
     *
     * @return array       Report information (not the report itself,
     *                     which is generated independently of the API call.)
     */

    public function createReport($params)
    {

    }

    /**
     * Status of a report
     *
     * @param  string       $reportId
     *
     * @return array        Report information. `file_url` has the download URL if the report
     *                      has been created.
     */

    public function reportStatus($reportId)
    {

    }

    /**
     * Trailing volume for all products for the last 30 days
     *
     * @return array         Information of trailing volume. Data is created once a day, and cached.
     */

    public function trailingVolume()
    {

    }

}
