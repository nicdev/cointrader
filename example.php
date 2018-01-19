<?php

require_once __DIR__ . '/vendor/autoload.php';

$apiClient = new Cointrader\PublicApi;

// Get a list of available products (currencies)
//print_r($apiClient->products());

// Get the curent BTC-USD order book (best bid/ask)
//print_r($apiClient->orderBook('BTC-USD', 1));

// Get the curent BTC-USD order book (complete)
//print_r($apiClient->orderBook('BTC-USD', 3));

// Get the BTC-USD ticker
//print_r($apiClient->ticker('BTC-USD'));

// Get the newest BTC-USD trades (always defaults to the max. of 100 results)
//print_r($apiClient->trades('BTC-USD'));

// Get the BTC-USD trades between trade #34112604 and #34112620
//print_r($apiClient->trades('BTC-USD', ['before' => 34112604, 'after' => 34112620]));

// Get the historical stats for BTC-USD
//print_r($apiClient->history('BTC-USD'));

// Get the historical stats for BTC-USD between
// 1/19/2018 @ 21:55 (9:55pm) - 1/19/2018 @ 22:00 (10:00pm) UTC.
// Granularity of 1 minute.
//print_r($apiClient->history('BTC-USD', '2018-01-19T21:55:00+00:00', '2018-01-19T22:00:00+00:00', 60));

// Get stats for the last 24 hours for BTC-USD
//print_r($apiClient->stats('BTC-USD'));

// Get a list of currencies known to Coinbase
//print_r($apiClient->currencies());

// Get the Coibase API server time
//print_r($apiClient->time());
