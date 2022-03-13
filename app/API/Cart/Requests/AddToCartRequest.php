<?php

namespace App\API\Cart\Requests;

use App\Domains\Cart\Actions\IAddToCartRequest;
use App\Domains\Product\Models\Product;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AddToCartRequest
 * @package App\API\Cart\Requests
 */
class AddToCartRequest extends FormRequest implements IAddToCartRequest
{
    /**
     * @return string[]
     */
    #[ArrayShape(['product_id' => "string", 'quantity' => "string"])] public function rules(): array
    {
        return [
            'product_id' => 'required',
            'quantity' => 'required|integer|min: 1'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $product = $this->getProduct();
            $this->validateInventory($validator, $product, $this->getQuantity());
        });
    }

    /**
     * @return Product
     * @throws Exception
     */
    public function getProduct(): Product
    {
        $product = Product::where('id', $this->input('product_id'))->first();

        if (empty($product)) {
            throw new Exception('Invalid product');
        }

        return $product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return (int)$this->input('quantity');
    }

    private function validateInventory(Validator $validator, Product $product, $quantity)
    {
        if($quantity > $product->inventories()->where('order_id', null)->count()) {
            $validator->errors()->add("order", __('Product :product is out of stock. :inventory_count remaining', ['product' => $product->name, 'inventory_count' => $product->inventories()->where('order_id', null)->count()]));
        }
    }
}
