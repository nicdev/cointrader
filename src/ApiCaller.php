<?php

namespace Cointrader;

use \GuzzleHttp\Client;


class ApiCaller implements ApiCallerInterface {

  protected $client;

  public function __construct($base_uri) {
    $this->client = new Client(['base_uri' => $base_uri]);
  }

  public function get($endpoint, array $query) {
    return $this->request('GET', $endpoint, $query);
  }

  public function post($endpoint, array $payload) {
    return $this->request('POST', $endpoint, $query);
  }

  private function request($method, $endpoint, $params) {
    $req = $this->client->request($method, $endpoint, $params);
    return json_decode((string) $req->getBody(), true);
  }

}
