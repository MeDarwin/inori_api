<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nisn'     => ['nullable', 'required_without_all:username,email,nis_nip', 'exclude_with:email', 'exclude_with:username', 'exclude_with:nis_nip'],
            'nis_nip'  => ['nullable', 'required_without_all:username,email,nisn', 'exclude_with:email', 'exclude_with:username', 'exclude_with:nisn'],
            'email'    => ['nullable', 'required_without_all:username,nis_nip,nisn', 'exclude_with:username', 'exclude_with:nis_nip', 'exclude_with:nisn'],
            'username' => ['nullable', 'required_without_all:email,nis_nip,nisn', 'exclude_with:email', 'exclude_with:nis_nip', 'exclude_with:nisn'],
            'password' => ['required'],
        ]);
        if ($token = auth()->attempt($validated)) {
            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60
            ]);
        }
        return response()->json(['message' => "Credential is incorrect"], 401);
    }
    public function getMe(Request $request): JsonResponse
    {
        return response()->json(auth()->user()->load('magazine'));
    }
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
