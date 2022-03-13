<?php

namespace App\Domains\Cart\Actions;

/**
 * Interface IAddToCartRequest
 * @package App\Domains\Cart\Actions
 */
interface IAddToCartRequest
{
    public function getProduct();

    public function getQuantity();
}
