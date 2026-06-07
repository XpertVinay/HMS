<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\V1\BaseApiController;

class AuthController extends BaseApiController
{
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $orgId = $this->orgId(); // Base controller provides this

        $result = $this->authService->attemptApi(
            $request->input('username'),
            $request->input('password'),
            $orgId
        );

        if ($result['success']) {
            return $this->sendResponse([
                'token' => $result['token'],
                'role' => $result['role'],
                'user' => $result['user']
            ], 'Login successful');
        }

        return $this->sendError($result['error'], [], 401);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // auth() will automatically use the correct guard based on the middleware
            auth()->logout();
            return $this->sendResponse([], 'Successfully logged out');
        } catch (\Exception $e) {
            return $this->sendError('Logout failed', [], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return $this->sendError('Unauthenticated.', [], 401);
        }

        return $this->sendResponse([
            'user' => $user
        ], 'Profile retrieved successfully');
    }
}
