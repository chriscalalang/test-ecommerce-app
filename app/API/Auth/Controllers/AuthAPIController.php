<?php

namespace App\API\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponseHandler;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

/**
 * Class AuthAPIController
 * @package App\API\Auth\Controllers
 */
class AuthAPIController extends Controller
{
    use APIResponseHandler;

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponseAlias
     */
    public function login(Request $request): JsonResponseAlias
    {
        if (!$token = auth()->attempt($this->getCredentials($request))) {
            return $this->error('auth.login', __('auth.failed'), 401);
        }

        return $this->success('auth.login', '', $this->respondWithToken($token));
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getCredentials(Request $request): array
    {
        $login = $request->get('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$fieldType => $login]);

        return $request->only(['username', 'email', 'password']);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60 * 60 * 24 * 7 //one week
        ];
    }
}
