<?php

namespace App\API\Cart\Controllers;

use App\API\Cart\Requests\AddToCartRequest;
use App\Domains\Cart\Actions\AddToCartAction;
use App\Domains\Cart\Actions\CreateCartAction;
use App\Domains\Cart\Models\Cart;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponseHandler;
use Illuminate\Http\JsonResponse;

/**
 * Class CartAPIController
 * @package App\API\Cart\Controllers
 */
class CartAPIController extends Controller
{
    use APIResponseHandler;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('is_active', true)->with('items')->latest()->first();

        return response()->json($cart->toArray());
    }

    /**
     * @param AddToCartRequest $addToCartRequest
     * @param CreateCartAction $createCartAction
     * @param AddToCartAction $addToCartAction
     * @return JsonResponse
     */
    public function store(AddToCartRequest $addToCartRequest, CreateCartAction $createCartAction, AddToCartAction $addToCartAction): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();

        if (empty($cart)) {
            $cart = $createCartAction->handle($user);
        }

        $item = $addToCartAction->handle($cart, $addToCartRequest);

        if (empty($item)) {
            return $this->error('api.cart', __('cart.failed'), 400, ['success' => false]);
        }

        return $this->success('api.cart', 'OK', ['success' => true]);
    }
}
