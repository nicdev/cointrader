<?php

namespace Cointrader;

/**
 *
 */

interface PublicApiClientInterface
{

  const PUBLIC_ENDPOINT = 'https://api.gdax.com';

  public function products();

  public function orderBook($product, $level);

  public function ticker($product);

  public function trades($product);

  public function history($product, $start, $end, $granularity);

  public function stats($product);

  public function currencies();

  public function time();

}
