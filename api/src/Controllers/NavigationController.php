<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseFormatter;

class NavigationController
{
    public function getNavigation(Request $request, Response $response)
    {
        $user = $request->getAttribute('user');
        $role = $user->user_type ?? 'member';

        // Dynamic modules based on RBAC
        $modules = [];

        switch ($role) {
            case 'super_admin':
            case 'admin':
            case 'staff':
                $modules = ['home', 'tickets', 'residents', 'vendors', 'reports', 'profile'];
                break;
            case 'vendor':
                $modules = ['home', 'assigned_jobs', 'marketplace', 'chat', 'profile'];
                break;
            case 'resident':
            case 'member':
            default:
                $modules = ['home', 'tickets', 'community', 'services', 'profile'];
                break;
        }

        $data = [
            'modules' => $modules,
            'permissions' => [] // Detailed permissions can go here if needed later
        ];

        return ResponseFormatter::success($response, $data, "Navigation fetched successfully");
    }
}
