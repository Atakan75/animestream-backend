<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Services\FileService;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserAvatarRequest;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return response_success([
            'message' => 'User created successfully',
            'user' => $user,
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response_error('auth.failed', 401);
        }

        $token = $user->createToken('anime_stream')->plainTextToken;

        return response_success([
            'message' => 'User logged in successfully',
            'token' => $token,
        ], 200);
    }

    public function setUserAvatar(UserAvatarRequest $request, FileService $fileService)
    {
        $user = $request->user();

        // Eski avatarı sil
        $user->avatar()->delete();

        // Yeni avatarı yükle
        $fileData = $fileService->uploadAvatar(
            $request->file('avatar'),
            $user->id
        );

        // Veritabanına kaydet
        $avatar = $user->avatar()->create($fileData);

        return response_success([
            'message' => 'Avatar başarıyla yüklendi',
            'avatar' => $avatar,
        ], 200);
    }
}
