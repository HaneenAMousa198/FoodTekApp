<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض جميع المستخدمين
    public function index()
    {
        $users = User::with('role')->latest()->get();
        return UserResource::collection($users);
    }

    // إنشاء مستخدم جديد
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return new UserResource($user->load('role'));
    }

    // عرض مستخدم محدد
    public function show(User $user)
    {
        return new UserResource($user->load('role'));
    }

    // تحديث بيانات مستخدم
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return new UserResource($user->load('role'));
    }

    // حذف مستخدم
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 200);
    }
}
