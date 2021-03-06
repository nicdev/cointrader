<?php

namespace Cointrader;

/**
 *
 */

interface PublicApiClientInterface
{

    const ENDPOINT_URL = 'https://api.gdax.com';

    public function products();

    public function orderBook($product, $level);

    public function ticker($product);

    public function trades($product, array $pagination);

    public function history($params);

    public function stats($product);

    public function currencies();

    public function time();
}
