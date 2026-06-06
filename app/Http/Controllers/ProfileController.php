<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private function getRoleConfig()
    {
        $role = session('account');
        $idKeys = [
            'admin' => 'aid',
            'super_admin' => 'aid',
            'staff' => 'aid',
            'member' => 'uid',
            'resident' => 'rid',
            'vendor' => 'vid',
        ];
        
        $modelMap = [
            'admin' => \App\Models\Admin::class,
            'super_admin' => \App\Models\SuperAdmin::class,
            'staff' => \App\Models\Staff::class,
            'member' => \App\Models\Member::class,
            'resident' => \App\Models\Resident::class,
            'vendor' => \App\Models\AppVendor::class,
        ];
        
        $userId = session($idKeys[$role] ?? 'uid');
        $model = $modelMap[$role] ?? \App\Models\Member::class;
        
        return [$role, $userId, $model];
    }

    public function index()
    {
        [$role, $userId, $model] = $this->getRoleConfig();
        $user = $model::findOrFail($userId);

        return view('profile.index', compact('user', 'role'));
    }

    public function update(Request $request)
    {
        [$role, $userId, $model] = $this->getRoleConfig();
        $user = $model::findOrFail($userId);

        // Common profile data
        $data = $request->only('email', 'phone', 'mobile_number', 'address');
        
        // Vendor specific
        if ($role === 'vendor' && $request->filled('contact_name')) {
            $data['contact_name'] = $request->contact_name;
        }
        
        // Map phone vs mobile_number properly if provided
        if ($request->filled('phone') && $role === 'resident') {
            $data['mobile_number'] = $request->phone;
            unset($data['phone']);
        }
        if ($request->filled('mobile_number') && in_array($role, ['admin', 'staff', 'member', 'vendor'])) {
            $data['phone'] = $request->mobile_number;
            unset($data['mobile_number']);
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function mobileAccess()
    {
        [$role, $userId, $model] = $this->getRoleConfig();
        $user = $model::findOrFail($userId);

        return view('profile.mobile_access', compact('user', 'role'));
    }

    public function generateQr()
    {
        [$role, $userId, $model] = $this->getRoleConfig();
        $user = $model::findOrFail($userId);
        
        $token = bin2hex(random_bytes(32));
        $orgId = $user->organization_id ?? 1;

        \Illuminate\Support\Facades\DB::table('qr_auth_tokens')->insert([
            'token' => $token,
            'user_type' => $role,
            'user_id' => $userId,
            'organization_id' => $orgId,
            'expires_at' => now()->addSeconds(60),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'qrToken' => $token,
            'expiresIn' => 60
        ]);
    }
}
