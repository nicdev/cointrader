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
