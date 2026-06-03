<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseFormatter;
use Firebase\JWT\JWT;
use Database;
use Rakit\Validation\Validator;

class AuthController
{
    private $secretKey = 'YOUR_SUPER_SECRET_KEY';

    public function login(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $validator = new Validator;

        $validation = $validator->make($parsedBody ?? [], [
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required|in:admin,member,staff,super_admin'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return ResponseFormatter::error($response, 'Validation failed', $validation->errors()->toArray(), 422);
        }

        $username = $parsedBody['username'];
        $password = md5($parsedBody['password']); // Legacy HMS password hashing
        $role = $parsedBody['role'];

        $pdo = Database::getInstance()->getPDO();

        $table = $role; // Table names match roles (admin, member, staff, super_admin)
        
        $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            return ResponseFormatter::error($response, 'Invalid credentials', null, 401);
        }

        // Generate Tokens
        $payload = [
            'iss' => 'hms-api',
            'aud' => 'hms-mobile',
            'iat' => time(),
            'user_id' => $user['id'],
            'role' => $role,
            'organization_id' => $user['organization_id'] ?? null
        ];

        // Access Token (15 mins)
        $accessPayload = $payload;
        $accessPayload['exp'] = time() + (15 * 60);
        $accessToken = JWT::encode($accessPayload, $this->secretKey, 'HS256');

        // Refresh Token (7 days)
        $refreshPayload = $payload;
        $refreshPayload['exp'] = time() + (7 * 24 * 60 * 60);
        $refreshPayload['jti'] = bin2hex(random_bytes(32)); // Unique ID for blacklisting
        $refreshToken = JWT::encode($refreshPayload, $this->secretKey, 'HS256');

        return ResponseFormatter::success($response, [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => 900,
            'user' => [
                'id' => $user['id'],
                'role' => $role,
                'name' => $user['name'] ?? $user['person_name'] ?? $user['username']
            ]
        ], "Login successful");
    }

    public function logout(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $validator = new Validator;

        $validation = $validator->make($parsedBody ?? [], [
            'refresh_token' => 'required'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            return ResponseFormatter::error($response, 'Validation failed', $validation->errors()->toArray(), 422);
        }

        $refreshToken = $parsedBody['refresh_token'];
        try {
            $decoded = JWT::decode($refreshToken, new \Firebase\JWT\Key($this->secretKey, 'HS256'));
            
            // Add JTI to denylist
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("INSERT INTO jwt_denylist (jti, user_id, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([
                $decoded->jti,
                $decoded->user_id,
                date('Y-m-d H:i:s', $decoded->exp)
            ]);

            return ResponseFormatter::success($response, null, "Logged out successfully");

        } catch (\Exception $e) {
            return ResponseFormatter::error($response, 'Invalid refresh token', null, 400);
        }
    }

    public function refresh(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $validator = new Validator;

        $validation = $validator->make($parsedBody ?? [], [
            'refresh_token' => 'required'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            return ResponseFormatter::error($response, 'Validation failed', $validation->errors()->toArray(), 422);
        }

        $refreshToken = $parsedBody['refresh_token'];

        try {
            $decoded = JWT::decode($refreshToken, new \Firebase\JWT\Key($this->secretKey, 'HS256'));
            
            // Check denylist
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT jti FROM jwt_denylist WHERE jti = ?");
            $stmt->execute([$decoded->jti]);
            if ($stmt->fetch()) {
                throw new \Exception("Token revoked");
            }

            // Issue new Access Token
            $accessPayload = [
                'iss' => 'hms-api',
                'aud' => 'hms-mobile',
                'iat' => time(),
                'exp' => time() + (15 * 60),
                'user_id' => $decoded->user_id,
                'role' => $decoded->role,
                'organization_id' => $decoded->organization_id
            ];
            
            $accessToken = JWT::encode($accessPayload, $this->secretKey, 'HS256');

            return ResponseFormatter::success($response, [
                'access_token' => $accessToken,
                'expires_in' => 900
            ], "Token refreshed");

        } catch (\Exception $e) {
            return ResponseFormatter::error($response, 'Invalid refresh token: ' . $e->getMessage(), null, 401);
        }
    }
}
