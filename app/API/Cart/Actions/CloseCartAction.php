<?php

namespace App\API\Cart\Actions;

use App\Domains\Cart\Models\Cart;

/**
 * Class CloseCartAction
 * @package App\API\Cart\Actions
 */
class CloseCartAction
{
    /**
     * @param Cart $cart
     */
    public function handle(Cart $cart)
    {
        $cart->is_active = false;
        $cart->save();
    }
}
