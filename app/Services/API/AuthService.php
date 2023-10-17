<?php

namespace App\Services\API;

use App\Http\Requests\API\AuthLoginRequest;
use Illuminate\Http\JsonResponse;

class AuthService
{

    public function login(array $credentials): JsonResponse
    {
        if (!$token = auth("api")->attempt($credentials)) {
            return response()->json(["message" => "Invalid user credentials"], 401);
        }

        return $this->responseWithToken($token);
    }
    public function logout()
    {
        auth("api")->logout();
        return response()->json(["message" => "Successfully"]);
    }

    public function refresh()
    {
        return $this->responseWithToken(
            auth("api")->refresh()
        );
    }

    private function responseWithToken(string $token): JsonResponse
    {
        return response()->json([
            "access_token" => $token,
            "type" => "Bearer",
            "expires_in" => config("jwt.ttl")
        ]);
    }
}
