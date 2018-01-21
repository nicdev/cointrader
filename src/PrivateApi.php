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
     * @param Cointrader\ApiCaller $apiCaller makes the actual requests to the API
     * @param string $key API key provided by Coinbase
     * @param string $secret API secret provided by Coinbase or you on Coinbase's settings
     * @param string $passphrase API passphrase provided by you on Coinbase's settings
     *
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
     * Returns all accounts for the authenticated user, or a single
     * account if an ID is passed
     *
     * @param  string $accountId (optional) limits the response to a single account
     * @return array with account information
     *
     */
    public function accounts($accountId = null)
    {
        $endpoint = $accountId ? "accounts/{$accountId}" : 'accounts';
        return $this->client->get($endpoint, [], true);
    }

    /**
     * Returns transaction history for an account
     * @param  string $accountId
     * @param  array  $pagination (optional)
     * @return array with transaction history for the account
     * 
     */
    public function accountHistory($accountId, $pagination = [])
    {
        $endpoint = "accounts/{$accountId}/ledger";
        return $this->client->get($endpoint, [], true);
    }

}
