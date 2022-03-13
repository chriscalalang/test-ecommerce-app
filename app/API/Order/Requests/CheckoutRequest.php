<?php

namespace App\API\Order\Requests;

use App\Domains\Coupon\Models\Coupon;
use App\Domains\Order\Actions\ICheckoutRequest;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CheckoutRequest
 * @package App\API\Order\Requests
 */
class CheckoutRequest extends FormRequest implements ICheckoutRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'orders.*.product_id' => 'required|integer',
            'orders.*.quantity' => 'required|integer|min: 1',
            'shipping_address.first_name' => 'required|string',
            'shipping_address.last_name' => 'required|string',
            'shipping_address.email' => 'required|email',
            'shipping_address.phone_number' => 'required|string',
            'shipping_address.address_line_1' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.zip_code' => 'required|string',
            'shipping_address.country' => 'required|string'
        ];
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->input('orders');
    }

    /**
     * @return null
     * @throws Exception
     */
    public function getCoupon()
    {
        if(empty($this->input('coupon_id'))) {
            return null;
        }

        $coupon = Coupon::find($this->input('coupon_id'));
        if(empty($coupon)) {
            throw new Exception('invalid coupon');
        }

        return $coupon;
    }

    public function getShippingAddress()
    {
        return $this->input('shipping_address');
    }
}
