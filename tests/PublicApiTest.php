<?php

use PHPUnit\Framework\TestCase;

class PublicApiTest extends TestCase
{

    protected function setUp()
    {
        $this->apiCaller = new Cointrader\PublicApi;
    }

    public function test_it_makes_a_call_to_products() {
      $products = $this->apiCaller->products();

      $this->assertTrue(is_array($products));
    }
  }
