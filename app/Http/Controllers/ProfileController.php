<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Storage\FileUploadService;

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

        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'profile_image_url' => 'nullable|url',
        ]);

        if ($role === 'admin') {
            $request->validate([
                'organization_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'organization_logo_url' => 'nullable|url',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gallery_image_urls.*' => 'nullable|url',
                'other_documents.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
                'other_document_urls.*' => 'nullable|url',
            ]);
        }

        // Common profile data
        $data = $request->only('email', 'phone', 'mobile_number', 'address', 'first_name', 'last_name');

        $fileService = new FileUploadService();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $fileService->upload($request->file('profile_image'), 'profiles');
        } elseif ($request->filled('profile_image_url')) {
            $data['profile_image'] = $request->profile_image_url;
        }

        if ($role === 'admin') {
            $gallery = $user->gallery_images ?? [];
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $gallery[] = $fileService->upload($file, 'gallery');
                }
            }
            if ($request->filled('gallery_image_urls')) {
                foreach ($request->gallery_image_urls as $url) {
                    if ($url) $gallery[] = $url;
                }
            }
            $data['gallery_images'] = $gallery;

            $docs = $user->other_documents ?? [];
            if ($request->hasFile('other_documents')) {
                foreach ($request->file('other_documents') as $file) {
                    $docs[] = $fileService->upload($file, 'documents');
                }
            }
            if ($request->filled('other_document_urls')) {
                foreach ($request->other_document_urls as $url) {
                    if ($url) $docs[] = $url;
                }
            }
            $data['other_documents'] = $docs;
            
            // Handle organization logo update
            if ($user->organization_id) {
                $org = \App\Models\Organization::find($user->organization_id);
                if ($org) {
                    $newLogoUrl = null;
                    if ($request->hasFile('organization_logo')) {
                        $newLogoUrl = $fileService->upload($request->file('organization_logo'), 'logos');
                    } elseif ($request->filled('organization_logo_url')) {
                        $newLogoUrl = $request->organization_logo_url;
                    }

                    if ($newLogoUrl) {
                        $org->logo_url = $newLogoUrl;
                        $org->save();

                        // Sync with active theme so it reflects on the web portal
                        $theme = $org->activeTheme;
                        if ($theme) {
                            $theme->logo_light = $newLogoUrl;
                            $theme->logo_dark = $newLogoUrl;
                            $theme->save();
                        }
                    }
                }
            }
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
