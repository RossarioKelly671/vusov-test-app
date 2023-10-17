<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserCreateRequest;
use App\Http\Requests\API\UserUpdateRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Services\API\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}


    public function create(UserCreateRequest $request)
    {
        $this->authorize("create", User::class);
        $validated = $request->validated();

        return $this->userService->create($validated);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize("update", [User::class, $user]);


        return $this->userService->update($request, $user);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize("show", [User::class, $user]);
        return $this->userService->show($user);
    }

    public function delete(User $user): JsonResponse
    {
        $this->authorize("delete", [User::class, $user]);
        return $this->userService->delete($user);
    }

}
