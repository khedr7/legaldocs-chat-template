<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function register_view()
    {
        if (Auth::user()){
            return redirect('/');
        }
        return view('user.register');
    }

    public function login_view()
    {
        if (Auth::user()){
            return redirect('/');
        }
        return view('user.login');
    }

    public function register(UserRequest $request)
    {
        $validatedData = $request->validated();
        $details = $this->userService->register($validatedData);

        return redirect('/')->with('success', __('messages.userSuccessfullyRegistered'));
    }

    public function login(UserRequest $request)
    {
        $validatedData = $request->validated();
        $details = $this->userService->login($validatedData);

        return redirect('/')->with('success', __('messages.userSuccessfullySignedIn'));
    }

    public function logout()
    {
        $this->userService->logout();

        return redirect('/login')->with('success', __('messages.userSuccessfullySignedOut'));
    }
}
