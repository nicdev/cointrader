<?php

namespace Cointrader;

/**
 *
 */

 class PublicApi implements PublicApiClientInterface {

   protected $client;

   public function __construct() {
      $this->client = new ApiCaller(self::PUBLIC_ENDPOINT);
   }

   public function products() {
      return $this->client->get('products', []);
   }

   public function orderBook($product, $level = 1) {
     return $this->client->get("products/{$product}/book", ['level' => $level]);
   }

   public function ticker($product) {
     return $this->client->get("products/{$product}/ticker", []);
   }

   public function trades($product, array $pagination = []) {
     return $this->client->get("products/{$product}/trades", $pagination);
   }

   public function history($product, $start, $end, $granularity) {
   }

   public function stats($product) {
   }

   public function currencies() {
   }

   public function time() {
   }
 }
