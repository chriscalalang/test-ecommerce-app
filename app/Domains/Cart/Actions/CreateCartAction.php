<?php

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\Models\Cart;
use App\Domains\User\Models\User;

/**
 * Class CreateCartAction
 * @package App\Domains\Cart\Actions
 */
class CreateCartAction
{
    /**
     * @param User $user
     * @return Cart
     */
    public function handle(User $user): Cart
    {
        $cart = new Cart;
        $cart->user_id = $user->id;
        $cart->is_active = true;

        $cart->save();
        return $cart;
    }
}
