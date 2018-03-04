<?php

namespace Cointrader;

use \GuzzleHttp\Client;

class ApiCaller implements ApiCallerInterface
{

    protected $client;
    protected $key;
    protected $secret;
    protected $passphrase;
    protected $baseUri;

    public function init($baseUri, $privateParams = [])
    {
        $this->client = new Client(['base_uri' => $baseUri]);
        $this->base_uri = $baseUri;

        if (array_key_exists('key', $privateParams) && array_key_exists('secret', $privateParams)
            && array_key_exists('passphrase', $privateParams)
        ) {
                $this->key = $privateParams['key'];
                $this->secret = $privateParams['secret'];
                $this->passphrase = $privateParams['passphrase'];
        }
    }

    protected function makeSignature($method, $endpoint, $body = null)
    {
        $body = is_array($body) ? json_encode($body) : $body;

        $requestPath = trim(substr($endpoint, 0, 1) === '/' ? $endpoint : '/' . $endpoint);
        $timestamp = time();
        $seed = $timestamp.$method.$requestPath.$body;

        return base64_encode(hash_hmac("sha256", $seed, base64_decode($this->secret), true));
    }

    protected function makeHeaders($signature)
    {
        return [
            'headers' => [
              'CB-ACCESS-SIGN' => $signature,
              'CB-ACCESS-TIMESTAMP' => time(),
              'CB-ACCESS-KEY' => $this->key,
              'CB-ACCESS-PASSPHRASE' => $this->passphrase,
              'Content-Type' => 'application/json'
            ]
        ];
    }

    public function get($endpoint, array $query = [])
    {
        return $this->request('GET', $endpoint, $query);
    }

    public function getPrivate($endpoint, array $query = [])
    {
        $headers = self::makeHeaders(self::makeSignature('GET', $endpoint));
        $params = array_merge($query, $headers);

        return $this->request('GET', $endpoint, $params);
    }

    public function post($endpoint, array $payload)
    {
        $payload = ['body' => json_encode($payload)];
        return $this->request('POST', $endpoint, $payload);
    }

    public function postPrivate($endpoint, array $payload)
    {
        $headers = self::makeHeaders(self::makeSignature('POST', $endpoint, $payload));
        $payload = ['body' => json_encode($payload)];
        $params = array_merge($payload, $headers);

        return $this->request('POST', $endpoint, $params);
    }

    public function delete($endpoint)
    {
        return $this->request('DELETE', $endpoint, null);
    }

    public function deletePrivate($endpoint, $payload = null)
    {
        $headers = self::makeHeaders(self::makeSignature('DELETE', $endpoint, $payload));

        return $this->request('DELETE', $endpoint, $headers);
    }

    public function request($method, $endpoint, $params)
    {
        try {
            $req = $this->client->request($method, $endpoint, $params);
            return json_decode((string) $req->getBody(), true);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
