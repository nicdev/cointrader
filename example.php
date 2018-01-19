<?php

require_once __DIR__ . '/vendor/autoload.php';

$apiClient = new Cointrader\PublicApi;

// Get a list of available products (currencies)
//print_r($apiClient->products());

// Get the curent BTC-USD order book (best bid/ask)
//print_r($apiClient->orderBook('BTC-USD', 1));

// Get the curent BTC-USD order book (complete)
//print_r($apiClient->orderBook('BTC-USD', 3));
