<?php

namespace Cointrader;

use \GuzzleHttp\Client;


class ApiCaller implements ApiCallerInterface
{

    protected $client;

  public function init($base_uri) {
    $this->client = new Client(['base_uri' => $base_uri]);
  }

  public function get($endpoint, array $query) {
    return $this->request('GET', $endpoint, ['query' => $query]);
  }

    public function get($endpoint, array $query)
    {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }


    public function post($endpoint, array $payload)
    {
        return $this->request('POST', $endpoint, ['body' => $payload]);

    }

  private function request($method, $endpoint, $params) {
    try {
      $req = $this->client->request($method, $endpoint, $params);
      return json_decode((string) $req->getBody(), true);
    } catch (Exception $e) {
      throw $e;
    }
  }

    private function request($method, $endpoint, $params)
    {
        try {
            //$params = array_merge($params, ['debug' => true]);
            $req = $this->client->request($method, $endpoint, $params);
            return json_decode((string) $req->getBody(), true);
        } catch (Exception $e) {
            throw $e;
        }

    }

}
