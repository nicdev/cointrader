<?php

namespace Cointrader;

/**
 *
 */

interface PrivateApiClientInterface
{

    const ENDPOINT_URL = 'https://api.gdax.com';

    public function tradingAccounts();

    public function accountHistory($accountId, $pagination);

    public function accountHolds($accountId, $pagination);

    public function placeOrder($params);

    public function cancelOrder($orderId);

    public function cancelAllOrders($productId);

    public function orders($status, $productId, $pagination);

    public function order($orderId);

    public function fills($orderId, $productId, $pagination);

    public function funding($status, $pagination);

    public function repay($params);

    public function marginTransfer($params);

    public function position();

    public function closePosition($repayOnly);

    public function deposit($params);

    public function coinbaseTransfer($params);

    public function withdraw($params);

    public function coinbaseWithdraw($params);

    public function withdrawCrypto($params);

    public function paymentMethods();

    public function coinbaseAccounts();

    public function createReport($params);

    public function reportStatus($reportId);

    public function trailingVolume();


}
