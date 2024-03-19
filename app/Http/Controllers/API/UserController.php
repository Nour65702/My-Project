<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ApiResponse;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreUserFormRequest;



class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $this->authorize('viewAny', User::class);
        $users->transform(function ($user) {
            FileHelper::getImageUrl($user);
            return $user;
        });
        return ApiResponse::success(['users' => $users]);
    }


    public function show(User $user)
    {
        $this->authorize('view', $user);

        FileHelper::getImageUrl($user);

        return ApiResponse::success(['user' => $user]);
    }

    public function update(StoreUserFormRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        FileHelper::getImageUrl($request, $user);

        return ApiResponse::success(['message' => 'User Updated successfully', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return ApiResponse::success(['message' => 'User deleted successfully']);
    }
}
