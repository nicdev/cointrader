<?php

namespace Cointrader;

/**
 *
 */

class PublicApi implements PublicApiClientInterface
{

    /**
     * @var $client must be an instance of Cointrader\ApiCaller
     */
    protected $client;

    /**
     * Creates a PublicApi object to use the public methods of the API
     *
     * @param Cointrader\ApiCaller $apiCaller makes the actual requests to the API
     */

    public function __construct(ApiCaller $apiCaller)
    {
        $this->client = $apiCaller;
        $this->client->init(self::ENDPOINT_URL);
    }

    /**
     * List of available currency pairs
     *
     * @return array   List of available currency pairs.
     */

    public function products()
    {
        return $this->client->get('products');
    }

    /**
     * List of open orders
     *
     * @param string  $product One of the available products.
     * @param integer $level   1, 2, or 3 see https://docs.gdax.com/#get-product-order-book
     *
     * @return array     List of open orders (results vary depending on level selected.)
     */

    public function orderBook($product, $level = 1)
    {
        return $this->client->get("products/{$product}/book", ['level' => $level]);
    }

    /**
     * Snapshot of the last trade
     *
     * @param string $product One of the available products.
     *
     * @return array    Information about the last trade.
     */

    public function ticker($product)
    {
        return $this->client->get("products/{$product}/ticker");
    }

    /**
     * List of trades
     *
     * @param string $product    One of the available products.
     * @param array  $pagination
     *
     * @return array    List of trades.
     */

    public function trades($product, array $pagination)
    {
        return $this->client->get("products/{$product}/trades", $pagination);
    }

    /**
     * Historical data for a product
     *
     * @param  array $params Start date, end date, granularity.
     *                       Dates must be in ISO 8061 format,
     *                       granularity is in seconds and must
     *                       be one of: 60, 300, 900, 3600,
     *                       21600, 86400
     * @return array  Historical information in "buckets." See https://docs.gdax.com/#get-historic-rates.
     */

    public function history($params)
    {
        return $this->client->get(
            "products/{$params['product']}/candles",
            [
              'start' => isset($params['start']) ? $params['start'] : null,
              'end' => isset($params['end']) ? $params['end'] : null,
              'granularity' => isset($params['granularity']) ? $params['granularity'] : 60
            ]
        );
    }

    /**
     * Stats for a product for the last 24 hours
     *
     * @param string    Product (BTC-USD, etc.)
     *
     * @return array     Overall trade information for the product
     */

    public function stats($product)
    {
        return $this->client->get("products/{$product}/stats");
    }

    /**
     * List known currencies
     *
     * @return array     Known currencies
     */

    public function currencies()
    {
        return $this->client->get('currencies');
    }

    /**
     * Current server time.
     *
     * @return array    Current time in ISO and Unix.
     */

    public function time()
    {
        return $this->client->get('time');
    }
}
