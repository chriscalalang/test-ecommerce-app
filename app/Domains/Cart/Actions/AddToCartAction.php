<?php


namespace App\Domains\Cart\Actions;


use App\Domains\Cart\Models\Cart;
use App\Domains\Cart\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

class AddToCartAction
{
    /**
     * @param Cart $cart
     * @param IAddToCartRequest $addToCartRequest
     * @return Model
     */
    public function handle(Cart $cart, IAddToCartRequest $addToCartRequest): Model
    {
        /**
         * if the product already exist in the cart. just add the quantity
         * @var CartItem $cartItem
         */
        $cartItem = $cart->items()->where('product_id', $addToCartRequest->getProduct()->id)->first();
        if (!empty($cartItem)) {
            $cartItem->quantity = $addToCartRequest->getQuantity();
            $cartItem->save();

            return $cartItem;
        }

        return $cart->items()->create([
            'product_id' => $addToCartRequest->getProduct()->id,
            'quantity' => $addToCartRequest->getQuantity()
        ]);

    }
}
