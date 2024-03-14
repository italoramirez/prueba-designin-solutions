<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObject\Auth\LoginData;
use App\Http\DataTransferObject\Auth\SaveData;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Response;

class AuthController extends Controller
{

    public function __construct(
        protected AuthService $userService
    )
    {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        return response()->json(
            $this->userService->register(SaveData::from($request), 201)
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            return response()->json(
                $this->userService->login(LoginData::from($request))
                , 200
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        if ($token) {
            $token->revoke();
            return response()->json('Logout successful', 200);
        }
    }
}
