<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $role = session('account');
        $userId = session('aid') ?? session('uid');

        $modelMap = [
            'admin' => \App\Models\Admin::class,
            'staff' => \App\Models\Staff::class,
            'super_admin' => \App\Models\SuperAdmin::class,
        ];

        $model = $modelMap[$role] ?? \App\Models\Admin::class;
        $user = $model::findOrFail($userId);

        return view('profile.index', compact('user', 'role'));
    }

    public function update(Request $request)
    {
        $role = session('account');
        $userId = session('aid') ?? session('uid');

        $modelMap = [
            'admin' => \App\Models\Admin::class,
            'staff' => \App\Models\Staff::class,
            'super_admin' => \App\Models\SuperAdmin::class,
        ];

        $model = $modelMap[$role] ?? \App\Models\Admin::class;
        $user = $model::findOrFail($userId);

        $data = $request->only('email', 'mobile_number');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
