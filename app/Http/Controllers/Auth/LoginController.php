<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Show the login form.
     */
    public function showForm()
    {
        // If already logged in, redirect to dashboard
        if (session('logged') === true) {
            return redirect()->route($this->authService->getDashboardRoute());
        }

        $themeClass = 'theme-member';
        $lastRole = request()->cookie('last_login_role');
        if ($lastRole === 'admin') {
            $themeClass = 'theme-admin';
        } elseif ($lastRole === 'staff') {
            $themeClass = 'theme-staff';
        }

        return view('auth.login', compact('themeClass'));
    }

    /**
     * Handle login attempt.
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $orgId = $this->orgId();

        $result = $this->authService->attempt(
            $request->input('username'),
            $request->input('password'),
            $orgId
        );

        if ($result['success']) {
            $request->session()->regenerate();
            return redirect()->route($result['redirect']);
        }

        return back()->withErrors(['login' => $result['error']])->withInput(['username' => $request->input('username')]);
    }
}
