<?php

namespace App\API\Order\Controllers;

use App\API\Cart\Actions\CloseCartAction;
use App\API\Order\Requests\CheckoutRequest;
use App\Domains\Cart\Models\Cart;
use App\Domains\Order\Actions\CheckoutAction;
use App\Domains\Order\Jobs\SendDiscountCoupon;
use App\Domains\User\Actions\CreateUserAction;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class CheckoutAPIController
 * @package App\API\Order\Controllers
 */
class CheckoutAPIController extends Controller
{
    use APIResponseHandler;

    private CreateUserAction $createUserAction;
    private CloseCartAction $closeCartAction;

    /**
     * CheckoutAPIController constructor.
     * @param CreateUserAction $createUserAction
     * @param CloseCartAction $closeCartAction
     */
    public function __construct(CreateUserAction $createUserAction, CloseCartAction $closeCartAction)
    {
        $this->createUserAction = $createUserAction;
        $this->closeCartAction = $closeCartAction;
    }

    /**
     * @param CheckoutRequest $checkoutRequest
     * @param CheckoutAction $checkoutAction
     * @return JsonResponse
     */
    public function checkout(CheckoutRequest $checkoutRequest, CheckoutAction $checkoutAction): JsonResponse
    {
        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = auth()->user();

            if (empty($user)) {
                $user = $this->createUserAction->handle($checkoutRequest->getShippingAddress());
            }

            $checkoutAction->handle($user, $checkoutRequest);

            //close active cart after checkout
            $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();
            if (!empty($cart)) {
                $this->closeCartAction->handle($cart);
            }

            //This will not work unless we setup a proper queue driver
            SendDiscountCoupon::dispatch($user)
                ->delay(now()->addSeconds(20));
        } catch (Exception $e) {
            DB::rollBack();
            $this->error('api.order', __('Ooops! something went wrong'));
        }

        DB::commit();
        return $this->success('api.order', 'OK', ['success' => true]);
    }
}
