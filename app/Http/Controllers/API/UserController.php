<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Helpers\ApiResponse;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreUserFormRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $users->transform(function ($user) {
            FileHelper::getImageUrl($user);
            return $user;
        });

        return ApiResponse::success(['users' => $users]);
    }

    public function store(StoreUserFormRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        FileHelper::getImageUrl($request, $user);

        return ApiResponse::success(['message' => 'User created successfully', 'user' => $user]);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        FileHelper::getImageUrl($user);

        return ApiResponse::success(['user' => $user]);
    }

    public function update(StoreUserFormRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        FileHelper::getImageUrl($request, $user);

        return ApiResponse::success(['message' => 'User Updated successfully', 'user' => $user]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return ApiResponse::success(['message' => 'User deleted successfully']);
    }
    public function roles(){
        $role = Role::all();
        return ApiResponse::success($role);
    }
}
