<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserAvatarRequest;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $check = User::where('name', $request->name)->first();

        if ($check) {
            return response_error('auth.name_exists', 400);
        }

        $user = User::create($request->validated());
        $token = $user->createToken('anime_stream')->plainTextToken;

        return response_success([
            'message' => 'User created successfully',
            'user'    => $user->load('roles'),
            'token'   => $token,
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
            'user'    => $user->load('roles'),
            'token'   => $token,
        ], 200);
    }

    public function setUserAvatar(UserAvatarRequest $request, FileService $fileService)
    {
        $user = $request->user();

        $user->avatar()->delete();

        $fileData = $fileService->uploadAvatar(
            $request->file('avatar'),
            $user->id
        );

        $avatar = $user->avatar()->create($fileData);

        return response_success([
            'message' => 'Avatar başarıyla yüklendi',
            'avatar'  => $avatar,
        ], 200);
    }

    public function stripeWebhook(Request $request)
    {
        $headers = collect($request->header())->except([
            'host', 'content-length', 'expect', 'connection',
        ])->toArray();

        $response = Http::withHeaders($headers)->post('https://app.shiphack.co/api/stripe/webhook', $request->all());

        return response()->json([
            'status'  => $response->status(),
            'body'    => $response->body(),
            'headers' => $response->headers(),
            'request' => $request->all(),
        ], $response->status());
    }
}
