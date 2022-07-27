<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\Models\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService)
    {
        return $authService->login($request);
    }

    public function register(RegisterRequest $request, AuthService $authService)
    {
        return $authService->register($request);
    }

    public function checkEmail(Request $request, AuthService $authService)
    {
        return $authService->checkEmail($request);
    }

    public function checkHash(Request $request, AuthService $authService)
    {
        return $authService->checkHash($request);
    }

    public function forgetPassword(ForgetPasswordRequest $request, AuthService $authService)
    {
        return $authService->forgetPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request, AuthService $authService)
    {
        return $authService->resetPassword($request);
    }

    public function checkToken(AuthService $authService)
    {
        return $authService->checkToken();
    }

    public function logout(AuthService $authService)
    {
        return $authService->logout();
    }

    public function profile(AuthService $authService, ProfileRequest $request)
    {
        return $authService->profile($request);
    }
}
