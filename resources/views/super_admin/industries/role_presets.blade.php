@extends('layouts.portal')

@section('title', 'Role Presets: ' . $industry->name)

@section('content')
<div class="content-header mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Role Presets: {{ $industry->name }}</h2>
    <a href="{{ route('super_admin.industries.index') }}" class="btn btn-secondary">
        <i class='bx bx-arrow-back'></i> Back
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Add New Role Preset -->
    <div class="md:col-span-1">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h4 class="font-bold mb-4">Add Role Template</h4>
            <form action="{{ route('super_admin.industries.role_presets.store', $industry->id) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role Name <span class="text-red-500">*</span></label>
                    <input type="text" name="role_name" class="form-control w-full rounded-lg" required placeholder="e.g., Admin, Broker, Vendor">
                    <small class="text-gray-500 mt-1 block">This role will be automatically created for any new {{ $industry->name }} organization.</small>
                </div>
                
                <h5 class="font-semibold mb-2 text-sm mt-4">Default Global Permissions</h5>
                <div class="max-h-64 overflow-y-auto border border-gray-200 dark:border-slate-600 rounded p-2 mb-4">
                    @foreach($globalPermissions as $permission)
                        <label class="flex items-center space-x-2 mb-1">
                            <input type="checkbox" name="default_permissions[]" value="{{ $permission->name }}" class="rounded text-primary-600 focus:ring-primary-500">
                            <span class="text-sm">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary w-full">Save Role Template</button>
            </form>
        </div>
    </div>

    <!-- Role Presets List -->
    <div class="md:col-span-2">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h4 class="font-bold mb-4">Configured Role Templates</h4>
            <div class="overflow-x-auto">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50">
                            <th class="p-4 border-b">Role Name</th>
                            <th class="p-4 border-b">Default Permissions</th>
                            <th class="p-4 border-b text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($presets as $preset)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30">
                                <td class="p-4 border-b font-bold text-primary-600">{{ $preset->role_name }}</td>
                                <td class="p-4 border-b text-sm">
                                    @if(is_array($preset->default_permissions) && count($preset->default_permissions) > 0)
                                        @foreach($preset->default_permissions as $perm)
                                            <span class="badge badge-info mb-1">{{ $perm }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 italic">None</span>
                                    @endif
                                </td>
                                <td class="p-4 border-b text-right">
                                    <form action="{{ route('super_admin.industries.role_presets.destroy', [$industry->id, $preset->id]) }}" method="POST" onsubmit="return confirm('Remove this role template?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"><i class='bx bx-trash'></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
