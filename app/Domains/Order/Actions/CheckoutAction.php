<?php

namespace App\Domains\Order\Actions;

use App\Domains\Order\Enums\OrderStatus;
use App\Domains\Order\Models\Order;
use App\Domains\Product\Models\Product;
use App\Domains\User\Models\User;
use Exception;

/**
 * Class CheckoutAction
 * @package App\Domains\Order\Actions
 */
class CheckoutAction
{
    /**
     * @param User $user
     * @param ICheckoutRequest $checkoutRequest
     * @throws Exception
     */
    public function handle(User $user, ICheckoutRequest $checkoutRequest)
    {
        $order = new Order;
        $order->user_id = $user->id;
        $order->coupon_id = $checkoutRequest->getCoupon();
        $order->status = OrderStatus::STATUS_PENDING;

        $order->save();

        $this->storeOrderItems($order, $checkoutRequest->getOrders());
    }

    /**
     * @param $order
     * @param array $items
     * @throws Exception
     */
    private function storeOrderItems($order, array $items)
    {
        foreach ($items as $anItem) {
            $product = Product::find($anItem['product_id']);

            if (empty($product)) {
                throw new Exception('Invalid product');
            }

            $order->items()->create([
                'product_id' => $anItem['product_id'],
                'quantity' => $anItem['quantity'],
                'product_name' => $product->name,
                'price' => $product->price,
                'line_total' => $product->price * $anItem['quantity']
            ]);
        }
    }
}
