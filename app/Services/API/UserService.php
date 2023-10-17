<?php

namespace App\Services\API;

use App\Http\Requests\API\UserUpdateRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserService
{

    public function create(array $validated)
    {
        $user = User::create($validated);
        dispatch(new SendEmailJob($user->email));

        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        if ($user->email != $validated["email"]) {
            $request->validate(["email" => ["unique:users"]]);
        }

        $user->update($validated);
        return response()->json($user);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(["message" => "Deleting is successful"]);
    }
}
