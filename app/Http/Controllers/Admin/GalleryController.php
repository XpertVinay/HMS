<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('organization_id', $this->orgId())->orderBy('uploaded_at', 'desc')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create() { return view('admin.gallery.create'); }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:150', 'image_url' => 'required|string|max:255']);
        Gallery::create(array_merge($request->only('title', 'image_url', 'description'), ['organization_id' => $this->orgId()]));
        return redirect()->route('admin.gallery.index')->with('success', 'Photo added.');
    }

    public function destroy(int $id)
    {
        Gallery::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Photo removed.');
    }
}
