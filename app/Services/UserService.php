<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ModelHelper;

    public function register($validatedData)
    {
        DB::beginTransaction();

        try {
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);

            DB::commit();

            Auth::login($user);

            $accessToken = $user->createToken('auth');

            return [
                'user' => $user,
                'token' => $accessToken->plainTextToken,
            ];
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function login(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $validatedData['email'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return back()->with('error', __('messages.credentialsError'));
            }
            Auth::login($user);

            $accessToken = $user->createToken('auth');

            DB::commit();

            return [
                'user' => $user,
                'token' => $accessToken->plainTextToken,
            ];
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
