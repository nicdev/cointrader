<?php

namespace Cointrader;

use \GuzzleHttp\Client;

/**
 *
 */

interface ApiCallerInterface
{
    public function init($base_uri, $privateParams);

    public function get($endpoint, array $query, $private);

    public function post($endpoint, array $payload, $private);

    public function request($method, $endpoint, $params);
}
