<?php

namespace Cointrader;

use \GuzzleHttp\Client;

/**
 *
 */

interface ApiCallerInterface
{
  public function get($endpoint, array $query);

  public function post($endpoint, array $payload);
}
