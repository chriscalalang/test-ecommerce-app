<?php

namespace App\Domains\Order\Actions;

/**
 * Interface ICheckoutRequest
 * @package App\Domains\Order\Actions
 */
interface ICheckoutRequest
{
    public function getOrders();

    public function getCoupon();

    public function getShippingAddress();
}
