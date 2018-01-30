<?php

namespace Cointrader;

use \GuzzleHttp\Client;

/**
 *
 */

interface ApiCallerInterface
{
    public function init($baseUri, $privateParams);

    public function get($endpoint, array $query);

    public function getPrivate($endpoint, array $query);

    public function post($endpoint, array $payload);

    public function postPrivate($endpoint, array $payload);

    public function delete($endpoint);

    public function deletePrivate($endpoint);

    public function request($method, $endpoint, $params);
}
