<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthLoginRequest;
use App\Services\API\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    )
    {
        $this->middleware("auth:api")->except("login");
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        return $this->authService->login($credentials);
    }
    public function logout()
    {
        return $this->authService->logout();
    }

    public function refresh()
    {
        return $this->authService->refresh();
    }
}
