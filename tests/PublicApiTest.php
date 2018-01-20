<?php

use PHPUnit\Framework\TestCase;

class PublicApiTest extends TestCase
{

    protected function setUp()
    {
        $this->publicApi = new Cointrader\PublicApi(new Cointrader\ApiCaller);
    }

    public function test_it_makes_a_call_to_products() {
      $products = $this->publicApi->products();

      $this->assertTrue(is_array($products));
    }
  }
