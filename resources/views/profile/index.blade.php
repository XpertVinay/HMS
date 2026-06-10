@extends('layouts.portal')
@section('title', 'My Profile')
@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h2>
    <div class="form-card">
        <form action="{{ route($role . '.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
                <label>Username / Login ID</label>
                <input type="text" value="{{ $user->username ?? $user->business_name }}" disabled class="bg-gray-100">
            </div>

            @include('partials.name_fields', ['user' => $user])

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="mobile_number"
                    value="{{ old('mobile_number', $user->mobile_number ?? $user->phone ?? '') }}">
            </div>

            <div class="form-group">
                <label>Profile Image (Upload or Paste URL)</label>
                @if(!empty($user->profile_image))
                    <img src="{{ (new \App\Services\Storage\FileUploadService())->getUrl($user->profile_image) }}" alt="Profile"
                        class="w-16 h-16 rounded-full mb-2 object-cover">
                @endif
                <input type="file" name="profile_image" accept="image/*" class="mb-2 w-full border p-2 rounded">
                <input type="url" name="profile_image_url" placeholder="Or paste image URL here..."
                    class="w-full border p-2 rounded">
            </div>

            @if($role === 'admin')
                <div class="form-group border-t border-gray-200 pt-4 mt-4">
                    <h3 class="font-semibold text-lg text-gray-700 mb-2">Organization Logo</h3>
                    <label class="text-sm text-gray-600 mb-1 block">Upload Organization Logo or Paste URL</label>

                    @php
                        $org = \App\Models\Organization::find($user->organization_id);
                    @endphp
                    @if($org && $org->logo_url)
                        <img src="{{ (new \App\Services\Storage\FileUploadService())->getUrl($org->logo_url) }}" alt="Organization Logo"
                            class="w-16 h-16 rounded mb-2 object-contain bg-gray-100 p-1 border">
                    @endif

                    <input type="file" name="organization_logo" accept="image/*" class="mb-2 w-full border p-2 rounded">
                    <input type="url" name="organization_logo_url" placeholder="Or paste image URL here..."
                        class="w-full border p-2 rounded">
                </div>

                <div class="form-group border-t border-gray-200 pt-4 mt-4">
                    <h3 class="font-semibold text-lg text-gray-700 mb-2">RWA Gallery Images</h3>
                    <label class="text-sm text-gray-600 mb-1 block">Upload Gallery Images or Paste URLs</label>

                    @if(!empty($user->gallery_images))
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach($user->gallery_images as $img)
                                <img src="{{ (new \App\Services\Storage\FileUploadService())->getUrl($img) }}" alt="Gallery Image"
                                    class="w-16 h-16 object-cover rounded">
                            @endforeach
                        </div>
                    @endif

                    <input type="file" name="gallery_images[]" accept="image/*" multiple class="mb-2 w-full border p-2 rounded">
                    <div id="gallery-urls">
                        <input type="url" name="gallery_image_urls[]" placeholder="Paste image URL here..."
                            class="w-full mb-2 border p-2 rounded">
                    </div>
                    <button type="button" onclick="addUrlInput('gallery-urls', 'gallery_image_urls[]')"
                        class="text-blue-500 text-sm mt-1 hover:underline">+ Add another URL</button>
                </div>

                <div class="form-group border-t border-gray-200 pt-4 mt-4">
                    <h3 class="font-semibold text-lg text-gray-700 mb-2">Other Documents</h3>
                    <label class="text-sm text-gray-600 mb-1 block">Upload Documents or Paste URLs</label>

                    @if(!empty($user->other_documents))
                        <ul class="list-disc pl-5 mb-2 text-sm text-blue-600">
                            @foreach($user->other_documents as $doc)
                                <li><a href="{{ (new \App\Services\Storage\FileUploadService())->getUrl($doc) }}" target="_blank">View
                                        Document</a></li>
                            @endforeach
                        </ul>
                    @endif

                    <input type="file" name="other_documents[]" accept=".pdf,.doc,.docx,image/*" multiple
                        class="mb-2 w-full border p-2 rounded">
                    <div id="document-urls">
                        <input type="url" name="other_document_urls[]" placeholder="Paste document URL here..."
                            class="w-full mb-2 border p-2 rounded">
                    </div>
                    <button type="button" onclick="addUrlInput('document-urls', 'other_document_urls[]')"
                        class="text-blue-500 text-sm mt-1 hover:underline">+ Add another URL</button>
                </div>

                <script>
                    function addUrlInput(containerId, inputName) {
                        const container = document.getElementById(containerId);
                        const input = document.createElement('input');
                        input.type = 'url';
                        input.name = inputName;
                        input.placeholder = 'Paste URL here...';
                        input.className = 'w-full mb-2 border p-2 rounded';
                        container.appendChild(input);
                    }
                </script>
            @endif

            <div class="form-group border-t border-gray-200 pt-4 mt-4">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-modern">Update Profile</button>
        </form>
    </div>
@endsection