<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $orgId = $this->orgId(); // Base controller provides this

        $result = $this->authService->attemptApi(
            $request->input('username'),
            $request->input('password'),
            $orgId
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'token' => $result['token'],
                'role' => $result['role'],
                'user' => $result['user']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 401);
    }
}
