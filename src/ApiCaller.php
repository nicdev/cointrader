<?php

namespace Cointrader;

use \GuzzleHttp\Client;

class ApiCaller implements ApiCallerInterface
{

    protected $client;
    protected $key;
    protected $secret;
    protected $passphrase;
    protected $base_uri;

    public function init($base_uri, $privateParams = [])
    {
        $this->client = new Client(['base_uri' => $base_uri]);
        $this->base_uri = $base_uri;

        if(array_key_exists('key', $privateParams) && array_key_exists('secret', $privateParams) && array_key_exists('passphrase', $privateParams)) {
            $this->key = $privateParams['key'];
            $this->secret = $privateParams['secret'];
            $this->passphrase = $privateParams['passphrase'];
        }
    }

    protected function makeSignature($method, $endpoint, $body = null)
    {
        $body = is_array($body) ? json_encode($body) : $body;
        $request_path = trim(substr($endpoint, 0, 1) === '/' ? $endpoint : '/' . $endpoint);
        $timestamp = time();
        $seed = $timestamp.$method.$request_path.$body;

        return base64_encode(hash_hmac("sha256", $seed, base64_decode($this->secret), true));
    }

    protected function makeHeaders($signature)
    {
        return
        ['headers' => [
          'CB-ACCESS-SIGN' => $signature,
          'CB-ACCESS-TIMESTAMP' => time(),
          'CB-ACCESS-KEY' => $this->key,
          'CB-ACCESS-PASSPHRASE' => $this->passphrase
        ]
        ];
    }

    public function get($endpoint, array $query, $private = false)
    {
        if($private) {
            $headers = self::makeHeaders(self::makeSignature('GET', $endpoint));
            $params = array_merge($query, $headers);
        } else {
            $params = $query;
        }
        return $this->request('GET', $endpoint, $params);
    }


    public function post($endpoint, array $payload, $private = false)
    {
        if($private) {
            $headers = self::makeHeaders(self::makeSignature('POST', $endpoint, $payload));
            $params = array_merge($payload, $headers);
        } else {
            $params = $payload;
        }
        return $this->request('POST', $endpoint, $params);
    }

    public function delete($endpoint, $private = false)
    {
        if($private) {
            $params = self::makeHeaders(self::makeSignature('DELETE', $endpoint));
        } else {
            $params = null;
        }
        return $this->request('DELETE', $endpoint, $params);
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
