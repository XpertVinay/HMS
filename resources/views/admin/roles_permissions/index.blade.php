@extends('layouts.portal')

@section('title', 'Organization Roles & Permissions Matrix')

@section('content')
<div class="content-header mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Roles & Permissions Matrix</h2>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
    <div class="flex gap-4 mb-6">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRoleModal">
            <i class='bx bx-plus'></i> Add Role
        </button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createPermissionModal">
            <i class='bx bx-plus'></i> Add Permission
        </button>
    </div>

    <form action="{{ route('admin.roles_permissions.matrix.update') }}" method="POST">
        @csrf
        @php
            $groupedPermissions = [];
            foreach($permissions as $p) {
                $parts = explode('.', $p->name);
                $module = count($parts) > 1 ? $parts[0] : 'General';
                $action = count($parts) > 1 ? $parts[1] : $p->name;
                $groupedPermissions[ucwords(str_replace('_', ' ', $module))][] = [
                    'id' => $p->id,
                    'action' => ucwords(str_replace('_', ' ', $action)),
                    'name' => $p->name,
                    'is_global' => is_null($p->organization_id)
                ];
            }
        @endphp
        <div class="overflow-x-auto">
            <table class="table w-full text-left border-collapse no-datatable">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50">
                        <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-bold text-gray-700 dark:text-gray-300 w-1/4">Module / Permission</th>
                        @foreach($roles as $role)
                            <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-semibold text-gray-700 dark:text-gray-300 text-center min-w-[120px]">
                                {{ Str::title(str_replace('_', ' ', $role->name)) }}
                                @if(!$role->organization_id)
                                    <br><span class="badge badge-info text-xs">Global</span>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupedPermissions as $module => $perms)
                        <!-- Module Header Row -->
                        <tr class="bg-gray-100 dark:bg-slate-700/80">
                            <td colspan="{{ count($roles) + 1 }}" class="p-3 border-b border-gray-200 dark:border-slate-600 font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wider text-sm">
                                <i class='bx bx-layer mr-2'></i>{{ $module }}
                            </td>
                        </tr>
                        
                        <!-- Actions Rows -->
                        @foreach($perms as $perm)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="p-3 pl-8 border-b border-gray-100 dark:border-slate-700 text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ $perm['action'] }}
                                    @if($perm['is_global'])
                                        <span class="badge badge-info text-[10px] ml-2">Global</span>
                                    @endif
                                </td>
                                
                                @foreach($roles as $role)
                                    <td class="p-3 border-b border-gray-100 dark:border-slate-700 text-center">
                                        @php
                                            $isDisabled = is_null($role->organization_id) ? 'disabled' : '';
                                        @endphp
                                        <label class="inline-flex items-center cursor-pointer {{ $isDisabled ? 'opacity-50' : '' }}">
                                            <input type="checkbox" 
                                                   name="permissions[{{ $role->id }}][]" 
                                                   value="{{ $perm['id'] }}"
                                                   {{ $role->hasPermissionTo($perm['name']) ? 'checked' : '' }}
                                                   {{ $isDisabled }}
                                                   class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        </label>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <small class="text-gray-500 mt-2 block">* Global roles cannot be modified by Organization Admins.</small>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-primary px-6 py-2">
                <i class='bx bx-save mr-2'></i> Save Matrix
            </button>
        </div>
    </form>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.roles_permissions.roles.store') }}" method="POST" class="modal-content bg-white dark:bg-slate-800 rounded-xl">
            @csrf
            <div class="modal-header border-b border-gray-100 dark:border-slate-700 p-4">
                <h5 class="modal-title font-bold">Create New Role</h5>
                <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role Name</label>
                    <input type="text" name="name" class="form-control w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700" required placeholder="e.g., Accountant">
                    <small class="text-gray-500 mt-1 block">Role will be scoped to your organization.</small>
                </div>
            </div>
            <div class="modal-footer border-t border-gray-100 dark:border-slate-700 p-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </div>
        </form>
    </div>
</div>

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.roles_permissions.permissions.store') }}" method="POST" class="modal-content bg-white dark:bg-slate-800 rounded-xl">
            @csrf
            <div class="modal-header border-b border-gray-100 dark:border-slate-700 p-4">
                <h5 class="modal-title font-bold">Create New Permission</h5>
                <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permission Name</label>
                    <input type="text" name="name" class="form-control w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700" required placeholder="e.g., manage_invoices">
                    <small class="text-gray-500 mt-1 block">Permission will be scoped to your organization.</small>
                </div>
            </div>
            <div class="modal-footer border-t border-gray-100 dark:border-slate-700 p-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Permission</button>
            </div>
        </form>
    </div>
</div>
@endsection
