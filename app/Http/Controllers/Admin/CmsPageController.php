<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use App\Services\Storage\FileUploadService;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');

        if ($isSuperAdmin) {
            $pages = CmsPage::whereNull('organization_id')->get();
        } else {
            $orgId = $this->orgId();
            $globalPages = CmsPage::whereNull('organization_id')->get();
            $orgPages = CmsPage::where('organization_id', $orgId)->get()->keyBy('slug');
            
            $pages = collect();
            foreach ($globalPages as $global) {
                if ($orgPages->has($global->slug)) {
                    $pages->push($orgPages->get($global->slug));
                } else {
                    $pages->push($global);
                }
            }
            
            foreach ($orgPages as $slug => $orgPage) {
                if (!$globalPages->contains('slug', $slug)) {
                    $pages->push($orgPage);
                }
            }
        }

        return view('admin.cms.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        $orgId = $isSuperAdmin ? null : $this->orgId();

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('cms_pages')->where(function ($query) use ($orgId) {
                    return $query->where('organization_id', $orgId);
                })
            ],
        ]);

        $slug = Str::start($request->slug, '/');

        CmsPage::create([
            'organization_id' => $orgId,
            'title' => $request->title,
            'slug' => $slug,
            'is_published' => false,
        ]);

        return redirect()->back()->with('success', 'Page created successfully.');
    }

    public function builder($id)
    {
        $page = CmsPage::findOrFail($id);
        
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        
        if (!$isSuperAdmin && is_null($page->organization_id)) {
            $orgId = $this->orgId();
            $existingOrgPage = CmsPage::where('organization_id', $orgId)->where('slug', $page->slug)->first();
            
            if ($existingOrgPage) {
                $page = $existingOrgPage;
            } else {
                $page = $page->replicate();
                $page->organization_id = $orgId;
                $page->save();
            }
            
            $routeName = request()->route()->getName();
            return redirect()->route($routeName, $page->id);
        }

        return view('admin.cms.builder', compact('page'));
    }

    public function saveBuilder(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');

        if (!$isSuperAdmin && is_null($page->organization_id)) {
            return response()->json(['error' => 'Cannot edit global page directly.'], 403);
        }

        $page->update([
            'html' => $request->input('html'),
            'css' => $request->input('css'),
            'gjs_data' => $request->input('gjs_data'), // optional, to store raw JSON
        ]);

        return response()->json(['message' => 'Page saved successfully.']);
    }

    public function uploadAsset(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $uploadedUrls = [];

            foreach ($files as $file) {
                // Using the FileUploadService which respects the environment config
                $path = $this->fileUploadService->upload($file, 'cms/assets');
                $uploadedUrls[] = $path;
            }

            // GrapesJS expects an array of data objects
            $data = array_map(function($url) {
                return ['src' => $url];
            }, $uploadedUrls);

            return response()->json(['data' => $data]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    public function togglePublish($id)
    {
        $page = CmsPage::findOrFail($id);
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');

        if (!$isSuperAdmin && is_null($page->organization_id)) {
            $orgId = $this->orgId();
            $existingOrgPage = CmsPage::where('organization_id', $orgId)->where('slug', $page->slug)->first();
            
            if ($existingOrgPage) {
                $page = $existingOrgPage;
            } else {
                $page = $page->replicate();
                $page->organization_id = $orgId;
                $page->save();
            }
        }
        
        $page->is_published = !$page->is_published;
        $page->save();

        return redirect()->back()->with('success', 'Page status updated.');
    }
}
