<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;

class UserProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('name', $username)->with('avatar')->first();

        if (!$user) {
            return response_error(['message' => 'User not found'], 404);
        }

        return response_success([
            'user' => new UserResource($user->load('roles')),
        ]);
    }
}
