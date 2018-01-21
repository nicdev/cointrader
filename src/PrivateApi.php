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

    public function accounts() 
    {
        return $this->client->get('accounts', [], true);
    }

}
