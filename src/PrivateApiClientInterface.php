<?php

namespace Cointrader;

/**
 *
 */

interface PrivateApiClientInterface
{

    const ENDPOINT_URL = 'https://api.gdax.com';

    public function accounts();
}
